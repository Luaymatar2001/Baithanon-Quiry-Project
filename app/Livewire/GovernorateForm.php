<?php

namespace App\Livewire;

use App\Models\governorates;
use Livewire\Component;

class GovernorateForm extends Component
{
    public $governorateId;
    public $name;


    public function mount($governorateId = null)
    {
        $this->governorateId = $governorateId;

        if ($this->governorateId) {
            $governorate = governorates::findOrFail($this->governorateId);
            $this->fillFromModel($governorate);
        }
    }

    protected function fillFromModel(governorates $governorate)
    {
        $this->name = $governorate->name;
    }



    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
        ]);


        if ($this->governorateId) {
            $governorate = governorates::findOrFail($this->governorateId);
            $governorate->update($validatedData);
            session()->flash('message', 'governorate updated successfully.');
        } else {
            governorates::create($validatedData);
            session()->flash('message', 'governorate created successfully.');
        }

        return redirect()->route('governorate.index');
    }
    public function render()
    {
        return view('livewire.governorate-form');
    }
}
