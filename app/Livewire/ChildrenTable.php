<?php

namespace App\Livewire;

// use App\Models\household; 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
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
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use App\Imports\ChildrensImport;
use App\Models\head_children;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;
// use PowerComponents\LivewirePowerGrid\Editable;

final class ChildrenTable extends PowerGridComponent
{
    use WithExport, WithFileUploads;
    public $excelFile;

    public function setUp(): array
    {
        $this->showCheckBox();
        if (auth()->user()->role === 'admin') {

            return [
                Header::make()
                    ->showSearchInput()
                    ->showToggleColumns(),
                Footer::make()
                    ->showPerPage()
                    ->showRecordCount(),
            ];
        }
        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
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
    public function onUpdatedEditable(
        mixed $id,
        string $field,
        mixed $value
    ): void {
        validator(
            [$field => $value],
            [$field => 'nullable|string|max:255']
        )->validate();

        head_children::where('id', $id)->update([$field => $value]);
    }


    public function datasource(): Builder
    {
        $head_children_data = head_children::query()
            ->leftJoin('heads_households', 'heads_children.householdId', '=', 'heads_households.personId')
            ->leftJoin('partners', 'partners.householdId', '=', 'heads_households.personId')
            ->leftJoin('city', 'heads_households.cityId', '=', 'city.id')
            ->leftJoin('locations', 'heads_households.location_id', '=', 'locations.id')
            ->leftJoin('governorates', 'heads_households.governorate_id', '=', 'governorates.id')
           ->select([
            'heads_children.*',

            'heads_households.FName as household_Fname',
            'heads_households.SName as household_Sname',
            'heads_households.TName as household_Tname',
            'heads_households.LName as household_Lname',
            'heads_households.phone_number as household_phone_number',

            'partners.FName as partner_Fname',
            'partners.SName as partner_Sname',
            'partners.TName as partner_Tname',
            'partners.LName as partner_Lname',

            'city.name as city_name',
            'locations.name as location_name',
            'governorates.name as governorate_name',
            DB::raw("
                CONCAT_WS(' ',
                    heads_households.FName,
                    heads_households.SName,
                    heads_households.TName,
                    heads_households.LName
                ) AS household_full_name
            "),
        ] );

      

            return $head_children_data;   
             }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('PersonId')
            ->add('FName')
            ->add('SName')
            ->add('TName')
            ->add('LName')
            ->add('BirthDate')
            ->add('Gender')
            ->add('relationship')
            ->add('householdId')
            ->add('user_name')
            ->add('household_Fname')
            ->add('household_Sname')
            ->add('household_Tname')
            ->add('household_Lname')
            ->add('city_name')
            ->add('location_name')
            ->add('governorate_name')
            ->add('partner_name')
            ->add('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('هوية الشخص', 'PersonId')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::make('الاسم الأول', 'FName')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::make('اسم الأب', 'SName')
                ->sortable()
                ->searchable()->editOnClick(),

            Column::make('اسم الجد', 'TName')
                ->sortable()
                ->searchable()->editOnClick(),

            Column::make('اللقب', 'LName')
                ->sortable()
                ->searchable()->editOnClick(),

            Column::make('تاريخ الميلاد', 'BirthDate')
                ->sortable()->editOnClick(),

            Column::make('الجنس', 'Gender')
                ->sortable()->editOnClick(),

            Column::make('العلاقة', 'relationship')
                ->sortable()
                ->searchable()->editOnClick(),

            Column::make('الحالة الصحية', 'health_Status')
                ->searchable()->editOnClick(),

            Column::make('هوية رب الأسرة', 'householdId')
                ->sortable()
                ->searchable(),
            
            Column::make('أسم الوالد' , 'household_full_name')
            ->sortable(),

            Column::make('رقم الهاتف', 'household_phone_number')
            ->sortable(),

            Column::make('المكان ','location_name') ->sortable(),
            Column::make('المدينة','city_name') ->sortable(),
            Column::make('المحافظة','governorate_name') ->sortable(),
            

            Column::make('أخر تحديث', 'updated_at')->sortable()->searchable(),


            Column::action('Action')

        ];
    }



    public function filters(): array
    {
        return [
            Filter::inputText('FName'),
             Filter::inputText('SName'),
             Filter::inputText('TName'),
            Filter::inputText('LName'),
            Filter::inputText('PersonId'),
            Filter::datePicker('BirthDate'),
            Filter::inputText('relationship'),
            Filter::inputText('householdId'),
            Filter::inputText('updated_at'),
            Filter::inputText('created_at'),    
            Filter::select('Gender')
                ->dataSource([
                    ['id' => 'ذكر', 'name' => 'ذكر'],
                    ['id' => 'أنثى', 'name' => 'أنثى'],
                    ['id' => 'انثى', 'name' => 'انثى'],
                    ['id' => '', 'name' => ''],
                ])
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::inputText('health_Status'),
            Filter::inputText('city_name')
             ->builder(function (Builder $query, mixed $value) {
                    $value = is_array($value) ? ($value['value'] ?? reset($value)) : $value;
                    $query->where('city.name', 'like', "%{$value}%");
                }),
            Filter::inputText('location_name')
              ->builder(function (Builder $query, mixed $value) {
                    $value = is_array($value) ? ($value['value'] ?? reset($value)) : $value;
                    $query->where('locations.name', 'like', "%{$value}%");
                }),

            Filter::inputText('governorate_name')
             ->builder(function (Builder $query, mixed $value) {
                    $value = is_array($value) ? ($value['value'] ?? reset($value)) : $value;
                    $query->where('governorates.name', 'like', "%{$value}%");
                }),
                
            Filter::inputText('household_name'),
                Filter::inputText('household_phone_number')
                ->builder(function (Builder $query, mixed $value) {
                    $value = is_array($value) ? ($value['value'] ?? reset($value)) : $value;
                    $query->where('heads_households.Phone_Number', 'like', "%{$value}%");
                }),
             Filter::inputText('household_full_name')
                ->builder(function (Builder $query, mixed $value) {
                    $value = is_array($value) ? ($value['value'] ?? reset($value)) : $value;
                    $query->where(function ($q) use ($value) {
                        $q->where('heads_households.FName', 'like', "%{$value}%")
                            ->orWhere('heads_households.SName', 'like', "%{$value}%")
                            ->orWhere('heads_households.TName', 'like', "%{$value}%")
                            ->orWhere('heads_households.LName', 'like', "%{$value}%")
                            ->orWhereRaw("CONCAT_WS(' ', heads_households.FName, heads_households.SName, heads_households.TName, heads_households.LName) LIKE ?", ["%{$value}%"]);
                    });
                }),



            // Filter::inputText('partner_name'),
            Filter::inputText('householdId')

        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function header(): array
    {
        if (auth()->user()->role === 'admin') {

            return [
                Button::add('refresh')
                    ->slot('<div class="bg-transparent dark:bg-pg-primary-800 font-semibold py-1.5 px-3 border border-gray-300 hover:border-transparent rounded" style="border-radius:5px; background-color:white;"> <i class="fa-solid fa-rotate"></i> </div>')
                    ->dispatch('pg:eventRefresh-default', []),
                Button::add('add')
                    ->slot('
                <a href="' . route('children.create') . '" class="bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
                    <i class="fa-solid fa-plus"></i> 
                </a>'),
            ];
        }
        return [
            Button::add('refresh')
                ->slot('<div class="bg-transparent dark:bg-pg-primary-800 font-semibold py-1.5 px-3 border border-gray-300 hover:border-transparent rounded" style="border-radius:5px; background-color:white;"> <i class="fa-solid fa-rotate"></i> </div>')
                ->dispatch('pg:eventRefresh-default', []),
            Button::add('bulk-delete')
                ->slot('<div class="bg-transparent dark:bg-pg-primary-800 font-semibold py-1.5 px-3 border border-gray-300 hover:border-transparent rounded" style="border-radius:5px; background-color:white;"> <i class="fa-solid fa-trash-can" style=""></i> </div>')
                ->dispatch('confirmBulkDelete', []),
            Button::add('add')
                ->slot('
                <a href="' . route('children.create') . '" class="bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
                    <i class="fa-solid fa-plus"></i> 
                </a>'),
            Button::add('import')
                ->slot('
            <label class="cursor-pointer bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
                <i class="fa-solid fa-file-import"></i>
                <input 
                    type="file"
                    wire:model="excelFile"
                    accept=".xlsx,.xls,.csv"
                    class="hidden"></label>'),
        ];
    }

    public function actions(head_children $row): array
    {

        return [
            Button::add('edit')
                ->slot('<i class="fa-regular fa-pen-to-square" style="font-size:20px; margin:2px"></i>')
                ->route('children.edit', ['child' => $row->id]),

            Button::add('delete')
                ->slot('<i class="fa-regular fa-trash-can" style="font-size:20px; margin:2px;"></i>')
                ->dispatch('confirmDelete', ['rowId' => $row->id]),

        ];
    }

    #[\Livewire\Attributes\On('confirmDelete')]
    public function confirmDelete($rowId): void
    {
        $this->js("
        if (confirm('هل أنت متأكد من الحذف؟')) {
            Livewire.dispatch('deleteRow', { rowId: {$rowId} });
        }
    ");
    }


    public function actionRules(head_children $row): array
    {
        return [
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }

    #[\Livewire\Attributes\On('deleteRow')]
    public function deleteRow($rowId): void
    {
        head_children::findOrFail($rowId)->delete();

        $this->dispatch('pg:eventRefresh-default');
    }

    #[\Livewire\Attributes\On('confirmBulkDelete')]
    public function confirmBulkDelete(): void
    {
        if (empty($this->checkboxValues)) {
            $this->js("alert('يرجى اختيار صف واحد على الأقل');");
            return;
        }

        $this->js("
        if (confirm('هل أنت متأكد من حذف السجلات المحددة؟')) {
            Livewire.dispatch('bulkDelete');
        }
    ");
    }

    #[\Livewire\Attributes\On('bulkDelete')]
    public function bulkDelete(): void
    {
        head_children::whereIn('id', $this->checkboxValues)->delete();
        $this->reset('checkboxValues');
        $this->dispatch('pg:eventRefresh-default');
    }

    public function updatedExcelFile()
    {

        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ChildrensImport, $this->excelFile);

            $this->js("alert('تم استيراد الملف بنجاح')");
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $messages = [];

            foreach ($failures as $failure) {
                $messages[] = "صف {$failure->row()}: " . implode(', ', $failure->errors());
            }

            $this->js("alert('حدثت أخطاء في الملف:\n" . implode("\n", $messages) . "')");
        }

        $this->reset('excelFile');
        $this->dispatch('pg:eventRefresh-default');
    }
}
