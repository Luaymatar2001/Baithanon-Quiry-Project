<?php

namespace App\Livewire;

use App\Models\partner;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class partnersForm extends Component
{
    public $partnerId;
    public $PersonId;
    public $FName;
    public $SName;
    public $TName;
    public $LName;
    public $birthdate;
    public $health_Status;
    public $relationship;
    public $householdId;
    public $desc_health_status_member;

    public function mount($partnerId = null)
    {
        $this->partnerId = $partnerId;

        if ($this->partnerId) {
            $partner = partner::findOrFail($this->partnerId);
            $this->fillFromModel($partner);
        }
    }

    protected function fillFromModel(partner $partner)
    {
        $this->PersonId = $partner->PersonId;
        $this->FName = $partner->FName;
        $this->SName = $partner->SName;
        $this->TName = $partner->TName;
        $this->LName = $partner->LName;
        $this->birthdate = $partner->birthdate;
        $this->relationship = $partner->relationship;
        $this->health_Status = $partner->health_Status;
        $this->householdId = $partner->householdId;
        $this->desc_health_status_member = $partner->desc_health_status;
    }



    public function save()
    {
        $validatedData = $this->validate([

            'PersonId' => [
                'required',
                'digits:9',
                Rule::unique('partners', 'PersonId')->ignore($this->partnerId),
            ],
            'FName' => 'required|string|max:255',
            'SName' => 'nullable|string|max:255',
            'TName' => 'nullable|string|max:255',
            'LName' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'health_Status' => 'nullable|string|max:255',
            'relationship' => 'nullable|string',
            'householdId' => 'required|digits:9|exists:heads_households,PersonId',
            'desc_health_status' => 'sometimes|string|max:255',
        ]);
        // dd($validatedData);


        if ($this->partnerId) {
            $partner = partner::findOrFail($this->partnerId);
            $partner->update($validatedData);
            session()->flash('message', 'partner updated successfully.');
        } else {
            partner::create($validatedData);
            session()->flash('message', 'partner created successfully.');
        }

        return redirect()->route('partner.index');
    }

    public function render()
    {
        return view('livewire.partners-form');
    }
}
