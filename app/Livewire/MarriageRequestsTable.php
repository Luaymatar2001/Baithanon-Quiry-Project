<?php

namespace App\Livewire;

use App\Models\MarriageRequest;
use App\Models\head_children;
use App\Models\household;
use App\Models\partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class MarriageRequestsTable extends PowerGridComponent
{
    public string $tableName = 'marriage_requests_table';

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return MarriageRequest::query()->latest('created_at');
    }

    public function header(): array
    {
        return [
            Button::add('refresh')
                ->slot('<div class="bg-white font-semibold py-1.5 px-3 border border-gray-300 rounded">
        <i class="fa-solid fa-rotate"></i>
    </div>')
                ->dispatch('pg:eventRefresh-marriage_requests_table', []),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),

            Column::make('بيانات الزوج', 'husband_full_name')
                ->searchable(false)
                ->sortable(false),

            Column::make('هوية الزوج', 'IdNumHouseHold_h')->searchable(),
            Column::make('تاريخ ميلاد الزوج', 'BirthDate_h')->sortable(),
            Column::make('رقم جوال الزوج', 'MobailNumber_h')->searchable(),

            Column::make('بيانات الزوجة', 'wife_full_name')
                ->searchable(false)
                ->sortable(false),

            Column::make('هوية الزوجة', 'IdNumWifeId')->searchable(),
            Column::make('تاريخ ميلاد الزوجة', 'BirthDate_w')->sortable(),

            Column::make('صورة هوية الزوج', 'husband_image_html')
                ->searchable(false)
                ->sortable(false),

            Column::make('صورة هوية الزوجة', 'wife_image_html')
                ->searchable(false)
                ->sortable(false),

            Column::action('Action'),
        ];
    }

    public function actions(MarriageRequest $row): array
    {
        return [
            Button::add('accept')
                ->slot('قبول')
                ->class('bg-green-600 text-white px-3 py-1 rounded')
                ->dispatch('acceptMarriageRequest', ['id' => $row->id]),

            Button::add('reject')
                ->slot('رفض')
                ->class('bg-red-600 text-white px-3 py-1 rounded')
                ->dispatch('rejectMarriageRequest', ['id' => $row->id]),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('husband_image_html', function ($row) {
                if (!$row->husband_national_id_image) {
                    return '-';
                }

                $url = asset('uploads/marriage_requests/' . $row->husband_national_id_image);

                return '<a href="' . $url . '" target="_blank">'
                    . '<img src="' . $url . '" width="130" style="border-radius:8px; cursor:pointer;">'
                    . '</a>';
            })
            ->add('wife_image_html', function ($row) {
                if (!$row->wife_national_id_image) {
                    return '-';
                }

                $url = asset('uploads/marriage_requests/' . $row->wife_national_id_image);

                return '<a href="' . $url . '" target="_blank">'
                    . '<img src="' . $url . '" width="130" style="border-radius:8px; cursor:pointer;">'
                    . '</a>';
            });
    }

    private function husbandFullName($row): string
    {
        return trim(collect([
            $row->FName_h,
            $row->SName_h,
            $row->TName_h,
            $row->LName_h,
        ])->filter()->implode(' '));
    }

    private function wifeFullName($row): string
    {
        return trim(collect([
            $row->FName_w,
            $row->SName_w,
            $row->TName_w,
            $row->LName_w,
        ])->filter()->implode(' '));
    }

    private function deleteImagesIfExist(MarriageRequest $request): void
    {
        $baseDir = public_path('uploads/marriage_requests');

        foreach (['husband_national_id_image', 'wife_national_id_image'] as $field) {
            $file = $request->{$field};
            if (!$file) {
                continue;
            }

            $path = $baseDir . DIRECTORY_SEPARATOR . $file;
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    #[On('acceptMarriageRequest')]
    public function accept($id): void
    {
        DB::transaction(function () use ($id) {
            /** @var MarriageRequest $req */
            $req = MarriageRequest::query()->findOrFail($id);

            // منع التكرار (اختياري/خفيف)
            // إذا كان PersonId الزوج موجوداً في heads_households مسبقاً سيحدث خطأ حسب unique/قيود.

            $householdCreated = household::create([
                'PersonId' => $req->IdNumHouseHold_h,
                'FName' => $req->FName_h,
                'SName' => $req->SName_h,
                'TName' => $req->TName_h,
                'LName' => $req->LName_h,
                'BirthDate' => $req->BirthDate_h,
                'Gender' => 'ذكر',
                'Phone_Number' => $req->MobailNumber_h,
                // الحقول الإضافية في migration قد تكون nullable؛ نتركها default أو null.
                'num_Family_Members' => 2,
                'legal_confirmation' => 1,
                'status' => '0',
            ]);

            // إنشاء الزوجة في partners
            $wife = partner::create([
                'PersonId' => $req->IdNumWifeId,
                'householdId' => $req->IdNumHouseHold_h,
                'FName' => $req->FName_w,
                'SName' => $req->SName_w,
                'TName' => $req->TName_w,
                'LName' => $req->LName_w,
                'relationship' => 'زوجة',
                'health_Status' => null,
                'birthdate' => $req->BirthDate_w,
                'desc_health_status' => null,
            ]);

            // تنفيذ نفس الربط منطقياً: partner مرتبط بـ householdId (PersonId في heads_households)
            // (لا يوجد جدول ربط آخر ظاهر في كود المشروع الحالي).

            // حذف الصور وسجل الطلب بعد نجاح الإنشاءات
            $this->deleteImagesIfExist($req);
            $req->delete();

            // لا نحتاج pg:eventRefresh هنا داخل transaction
            // (سيتم بعد انتهاء التابع)
        });

        $this->dispatch('pg:eventRefresh');
    }

    #[On('rejectMarriageRequest')]
    public function reject($id): void
    {
        DB::transaction(function () use ($id) {
            $req = MarriageRequest::query()->findOrFail($id);

            $this->deleteImagesIfExist($req);
            $req->delete();
        });

        $this->dispatch('pg:eventRefresh');
    }
}
