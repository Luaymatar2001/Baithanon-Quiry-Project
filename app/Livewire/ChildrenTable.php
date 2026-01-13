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
        return head_children::query();
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
                ->sortable(),

            Column::make('العلاقة', 'relationship')
                ->sortable(),

            Column::make('الحالة الصحية', 'health_Status')
                ->searchable(),

            Column::make('أخر تحديث', 'updated_at')
                ->searchable(),

            Column::action('Action')

        ];
    }



    public function filters(): array
    {
        return [
            Filter::inputText('FName'),
            Filter::inputText('LName'),
            Filter::inputText('PersonId'),
            Filter::select('Gender')
                ->dataSource([
                    ['id' => 'ذكر', 'name' => 'ذكر'],
                    ['id' => 'أنثى', 'name' => 'أنثى'],
                ])
                ->optionLabel('name')
                ->optionValue('id'),
            Filter::inputText('health_Status'),

        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function header(): array
    {
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
            // Hide button edit for ID 1
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
