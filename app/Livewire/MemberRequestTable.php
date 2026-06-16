<?php

namespace App\Livewire;

use App\Models\head_children;
use App\Models\household;
use App\Models\MemberRequest;
use App\Models\partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Livewire\Attributes\On;

final class MemberRequestTable extends PowerGridComponent
{
    public string $tableName = 'member_request_table';

    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
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
        return MemberRequest::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function header(): array
    {
        return [

            Button::add('export')
                ->slot('
            <label class="cursor-pointer bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
                <i class="fa-solid fa-file-export"></i>
                <input 
                    type="file"
                    wire:model="excelFile"
                    accept=".xlsx,.xls,.csv"
                    class="hidden"></label>'),
            Button::add('refresh')
                ->slot('<div class="bg-transparent dark:bg-pg-primary-800 font-semibold py-1.5 px-3 border border-gray-300 hover:border-transparent rounded" style="border-radius:5px; background-color:white;"> <i class="fa-solid fa-rotate"></i> </div>')
                ->dispatch('pg:eventRefresh-default', []),
            Button::add('bulk-delete')
                ->slot('<div class="bg-transparent dark:bg-pg-primary-800 font-semibold py-1.5 px-3 border border-gray-300 hover:border-transparent rounded" style="border-radius:5px; background-color:white;"> <i class="fa-solid fa-trash-can" style=""></i> </div>')
                ->dispatch('confirmBulkDelete', []),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),

            Column::make('رقم الهوية', 'PersonId')
                ->searchable()
                ->editOnClick(),
            Column::make('الاسم الأول', 'FName')
                ->searchable()
                ->sortable()
                ->editOnClick(),

            Column::make('اسم الأب', 'SName')
                ->searchable()
                ->editOnClick(),

            Column::make('اسم الجد', 'TName')->editOnClick(),

            Column::make('العائلة', 'LName')->editOnClick(),

            Column::make('هوية رب الأسرة', 'household_id')->editOnClick(),



            Column::make('العلاقة', 'relation')
            ->editOnClick(),
            
            Column::make('تاريخ الميلاد', 'BirthDate')
                ->sortable()
                ->editOnClick(),

            // Column::make('صورة الهوية', 'identity_image')
            //     ->sortable(),
            // Column::make('شهادة الميلاد', 'birth_certificate')
            //     ->sortable(),
            // Column::make('صورة الهوية لرب الأسرة ', 'household_id_image')
            //     ->sortable(),
            Column::make('صورة الهوية', 'identity_image_html')
                ->searchable(false)
                ->sortable(false),
            Column::make('شهادة الميلاد', 'birth_certificate_html')
                ->searchable(false)
                ->sortable(false)->editOnClick(),
            Column::make('صورة الهوية لرب الأسرة ', 'household_id_image_html')
                ->searchable(false)
                ->sortable(false),

            Column::make('الحالة', 'status')
                ->sortable()->editOnClick(),
            Column::make('تاريخ المراجعة', 'reviewed_at')
                ->sortable(),
            Column::make('تاريخ الإنشاء', 'created_at'),
            Column::action('Action'),
        ];
    }


    public function actions(MemberRequest $row): array
    {
        return [
            Button::add('accept')
                ->slot('قبول')
                ->class('bg-green-600 text-white px-3 py-1 rounded')
                ->dispatch('acceptRequest', ['id' => $row->id]),

            Button::add('reject')
                ->slot('رفض')
                ->class('bg-red-600 text-white px-3 py-1 rounded')
                ->dispatch('rejectRequest', ['id' => $row->id]),
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add(
                'identity_image_html',
                fn($row) =>
                $row->identity_image
                    ? '<a href="' . asset('uploads/' . $row->identity_image) . '" target="_blank">
                    <img src="' . asset('uploads/' . $row->identity_image) . '"
                         width="130"
                         style="border-radius:8px; cursor:pointer;">
               </a>'
                    : '-'
            )

            ->add(
                'birth_certificate_html',
                fn($row) =>
                $row->birth_certificate
                    ? '<a href="' . asset('uploads/' . $row->birth_certificate) . '" target="_blank">
                    <img src="' . asset('uploads/' . $row->birth_certificate) . '"
                         width="130"
                         style="border-radius:8px;cursor:pointer;">
               </a>'
                    : '-'
            )

            ->add(
                'household_id_image_html',
                fn($row) =>
                $row->household_id_image
                    ? '<a href="' . asset('uploads/' . $row->household_id_image) . '" target="_blank">
                    <img src="' . asset('uploads/' . $row->household_id_image) . '"
                         width="130"
                         style="border-radius:8px;cursor:pointer;">
               </a>'
                    : '-'
            );
    }

    #[On('acceptRequest')]
    public function accept($id)
    {
        DB::transaction(function () use ($id) {

            $request = MemberRequest::findOrFail($id);
            $createdModel = null;

            $gender = match ($request->relation) {
                'ابن' => 'ذكر',
                'ابنه' => 'أنثى',
                default => null,
            };

            if ($request->relation === 'زوجة') {
                $createdModel = partner::create([
                    'PersonId' => $request->PersonId,
                    'householdId' => $request->household_id,
                    'FName' => $request->FName,
                    'SName' => $request->SName,
                    'TName' => $request->TName,
                    'LName' => $request->LName,
                    'relationship' => $request->relation,
                    'health_Status' => $request->health_status,
                    'birthdate' => $request->BirthDate,
                    'desc_health_status' => $request->desc_health_status_member,
                ]);
            }

            if (in_array($request->relation, ['ابن', 'ابنه'])) {
                $createdModel = head_children::create([
                    'PersonId' => $request->PersonId,
                    'householdId' => $request->household_id,
                    'FName' => $request->FName,
                    'SName' => $request->SName,
                    'TName' => $request->TName,
                    'LName' => $request->LName,
                    'relationship' => $request->relation,
                    'health_Status' => $request->health_status,
                    'BirthDate' => $request->BirthDate,
                    'Gender' => $gender,
                    'desc_health_status' => $request->desc_health_status_member,
                ]);
            }

            if (!$createdModel) {
                throw new \Exception('Creation failed');
            }

            $this->deleteMemberRequestFiles($request);

            $request->delete();

            $household = household::select('id', 'PersonId', 'num_Family_Members')
                ->where('PersonId', $request->household_id)
                ->firstOrFail();

            if ($household->getcurrentMembersCount() > $household->num_Family_Members) {
                $household->addMemberAndCheckLimit();
            }
        });

        $this->dispatch('pg:eventRefresh');
    }

    private function deleteMemberRequestFiles(MemberRequest $request): void
    {
        foreach (
            [
                'identity_image',
                'birth_certificate',
                'household_id_image',
            ] as $file
        ) {
            if ($request->$file) {
                Storage::disk('public_uploads')->delete($request->$file);
            }
        }
    }

    #[On('rejectRequest')]
    public function reject($id)
    {
        DB::transaction(function () use ($id) {

            $request = MemberRequest::findOrFail($id);

            // حذف الملفات من السيرفر
            $files = [
                'identity_image',
                'birth_certificate',
                'household_id_image',
            ];

            foreach ($files as $file) {
                if ($request->$file) {
                    Storage::disk('public_uploads')->delete($request->$file);
                }
            }

            // حذف السجل
            $request->delete();
        });

        $this->dispatch('pg:eventRefresh');
    }
}
