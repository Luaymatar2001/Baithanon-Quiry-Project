<?php

namespace App\Livewire;

use App\Models\city;
use App\Models\governorates;
use Livewire\Component;

class cityForm extends Component
{
    public $cityId;
    public $name;
    public $governorateId;
    public $city;
    public $AllGovernorate = [];


    public function mount($cityId = null)
    {
        $this->cityId = $cityId;
        $this->AllGovernorate = governorates::pluck('name', 'id');


        if ($this->cityId) {
            $city = city::findOrFail($this->cityId);
            $this->fillFromModel($city);
        }
    }

    protected function fillFromModel(city $city)
    {
        $this->name = $city->name;
        $this->governorateId = $city->governorateId;
    }



    public function save()
    {
        // $this->resetErrorBag();

        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'governorateId' => 'required|exists:governorates,id',
        ]);


        if ($this->cityId) {
            $city = city::findOrFail($this->cityId);
            $city->update($validatedData);
            session()->flash('message', 'city updated successfully.');
        } else {
            city::create($validatedData);
            session()->flash('message', 'city created successfully.');
        }

        return redirect()->route('city.index');
    }
    public function render()
    {
        return view('livewire.city-form');
    }
}
