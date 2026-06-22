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
use App\Models\governorates;
// use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Validators\ValidationException;
// use PowerComponents\LivewirePowerGrid\Editable;

final class GovernorateTable extends PowerGridComponent
{
    use WithExport, WithFileUploads;
    public $excelFile;

    public function setUp(): array
    {
        if (auth()->user()->role === 'admin') {

            $this->showCheckBox();

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

        governorates::where('id', $id)->update([$field => $value]);
    }


    public function datasource(): Builder
    {
        return governorates::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('updated_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),
            Column::make('الإسم', 'name')
                ->sortable()
                ->searchable(),

            Column::make('أخر تحديث', 'updated_at')->sortable()->searchable(),

            Column::action('Action')

        ];
    }



    public function filters(): array
    {
        return [
            Filter::inputText('name'),
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
                <a href="' . route('governorate.create') . '" class="bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
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
                <a href="' . route('governorate.create') . '" class="bg-white font-semibold py-1.5 px-3 border border-gray-300 hover:border-gray-400 rounded inline-block">
                    <i class="fa-solid fa-plus"></i> 
            </a>'),
        ];
    }

    public function actions(governorates $row): array
    {
            return [
                Button::add('edit')
                    ->slot('<i class="fa-regular fa-pen-to-square" style="font-size:20px; margin:2px"></i>')
                    ->route('governorate.edit', ['governorate' => $row->id]),

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


    public function actionRules(governorates $row): array
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
        governorates::findOrFail($rowId)->delete();

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
        governorates::whereIn('id', $this->checkboxValues)->delete();
        $this->reset('checkboxValues');
        $this->dispatch('pg:eventRefresh-default');
    }
}
