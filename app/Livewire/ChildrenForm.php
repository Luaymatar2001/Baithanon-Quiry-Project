<?php

namespace App\Livewire;

use App\Models\head_children;
use App\Models\city;
use App\Models\location;
use App\Models\governorates;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class childrenForm extends Component
{
    public $childrenId;
    public $PersonId;
    public $FName;
    public $SName;
    public $TName;
    public $LName;
    public $BirthDate;
    public $Gender;
    public $health_Status;
    public $relationship;

    public function mount($childrenId = null)
    {
        $this->childrenId = $childrenId;

        if ($this->childrenId) {
            $children = head_children::findOrFail($this->childrenId);
            $this->fillFromModel($children);
        }
    }

    protected function fillFromModel(head_children $children)
    {
        $this->PersonId = $children->PersonId;
        $this->FName = $children->FName;
        $this->SName = $children->SName;
        $this->TName = $children->TName;
        $this->LName = $children->LName;
        $this->BirthDate = $children->BirthDate;
        $this->Gender = $children->Gender;
        $this->relationship = $children->relationship;
        $this->health_Status = $children->health_Status;
    }



    public function save()
    {
        $validatedData = $this->validate([

            'PersonId' => [
                'required',
                Rule::unique('heads_children', 'PersonId')->ignore($this->childrenId),
            ],
            'FName' => 'required|string|max:255',
            'SName' => 'nullable|string|max:255',
            'TName' => 'nullable|string|max:255',
            'LName' => 'required|string|max:255',
            'BirthDate' => 'nullable|date',
            'Gender' => 'required|in:ذكر,أنثى',
            'health_Status' => 'nullable|string|max:255',
            'relationship' => 'nullable|string',
        ]);


        if ($this->childrenId) {
            $children = head_children::findOrFail($this->childrenId);
            $children->update($validatedData);
            session()->flash('message', 'children updated successfully.');
        } else {
            head_children::create($validatedData);
            session()->flash('message', 'children created successfully.');
        }

        return redirect()->route('children.index');
    }

    public function render()
    {
        return view('livewire.children-form');
    }
}
