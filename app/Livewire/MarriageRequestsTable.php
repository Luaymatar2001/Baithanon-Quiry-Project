<?php

namespace App\Livewire;

use App\Models\MarriageRequest;
use App\Models\head_children;
use App\Models\household;
use App\Models\partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\UniqueConstraintViolationException;
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
use PowerComponents\LivewirePowerGrid\Facades\Filter;

use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class MarriageRequestsTable extends PowerGridComponent
{
    public string $tableName = 'marriage_requests_table';

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
            // Header::make()->showSearchInput(),
            // Footer::make()
            //     ->showPerPage()
            //     ->showRecordCount(),
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
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

            Column::make('هوية الزوج', 'IdNumHouseHold_h')->searchable()->editOnClick(),

            Column::make('أسم الزوج الأول', 'FName_h')
                ->searchable(false)
                ->sortable(false)->editOnClick(),
            Column::make('أسم الأب', 'SName_h')
                ->searchable(false)
                ->sortable(false)->editOnClick(),
            Column::make('أسم الجد', 'TName_h')
                ->searchable(false)
                ->sortable(false)->editOnClick(),
            Column::make('أسم العائلة', 'LName_h')
                ->searchable(false)
                ->sortable(false)->editOnClick(),
            Column::make('تاريخ ميلاد الزوج', 'BirthDate_h')->sortable()->editOnClick(),
            Column::make('رقم جوال الزوج', 'MobailNumber_h')->searchable()->editOnClick(),

            Column::make('أسم الزوجة الأول', 'FName_w')
                ->searchable(false)
                ->sortable(false)
                ->editOnClick(),

            Column::make('أسم الأب', 'SName_w')
                ->searchable(false)
                ->sortable(false)
                ->editOnClick(),

            Column::make('أسم الجد', 'TName_w')
                ->searchable(false)
                ->sortable(false)
                ->editOnClick(),

            Column::make('أسم العائلة', 'LName_w')
                ->searchable(false)
                ->sortable(false)
                ->editOnClick(),

            Column::make('هوية الزوجة', 'IdNumWifeId')->searchable()->editOnClick(),
            Column::make('تاريخ ميلاد الزوجة', 'BirthDate_w')->sortable()->editOnClick(),

            Column::make('صورة هوية الزوج', 'husband_image_html'),

            Column::make('صورة هوية الزوجة', 'wife_image_html'),

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
            ->add('IdNumHouseHold_h')
            ->add('BirthDate_h')
            ->add('MobailNumber_h')
            ->add('FName_h')
            ->add('SName_h')
            ->add('TName_h')
            ->add('LName_h')
            ->add('IdNumWifeId')
            ->add('BirthDate_w')
            ->add('FName_w')
            ->add('SName_w')
            ->add('TName_w')
            ->add('LName_w')
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
    public function onUpdatedEditable(
        mixed $id,
        string $field,
        mixed $value
    ): void {
        validator(
            [$field => $value],
            [$field => 'nullable|string|max:255']
        )->validate();

        MarriageRequest::where('id', $id)->update([$field => $value]);
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



    public function filters(): array
    {
        return [
            Filter::inputText('FName_h'),
            Filter::inputText('LName_h'),
            Filter::inputText('IdNumHouseHold_h'),

            Filter::inputText('FName_w'),
            Filter::inputText('LName_w'),
            Filter::inputText('IdNumWifeId'),
            Filter::inputText('MobailNumber_h'),

            Filter::inputText('status'),
            Filter::inputText('num_Family_Members'),
            Filter::inputText('health_Status'),

        ];
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
        try {
        DB::transaction(function () use ($id) {
            /** @var MarriageRequest $req */
            $req = MarriageRequest::query()->findOrFail($id);

            // منع التكرار (اختياري/خفيف)
            // إذا كان PersonId الزوج موجوداً في heads_households مسبقاً سيحدث خطأ حسب unique/قيود.

            $householdCreated = household::updateOrCreate([
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
            $wife = partner::updateOrCreate([
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
        } catch (UniqueConstraintViolationException $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'title' => 'خطأ - تكرار في البيانات',
                'message' => 'رقم الهوية هذا مسجّل مسبقاً، لا يمكن إضافته مرة أخرى.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'title' => 'خطأ',
                'message' => 'حدث خطأ أثناء معالجة الطلب، يرجى المحاولة مجدداً.',
            ]);
        }
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
