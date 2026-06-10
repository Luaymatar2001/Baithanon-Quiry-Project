<?php

namespace App\Livewire;

use App\Models\governorates;
use App\Models\location;
use App\Models\city;
use Livewire\Component;

class LocationsForm extends Component
{
    public $name;
    public $locationId;
    public $city;
    public $city_id;
    public $AllCity = [];


    public function mount($locationId = null)
    {
        $this->locationId = $locationId;
        $this->AllCity = city::pluck('name', 'id');


        if ($this->locationId) {
            $location = location::findOrFail($this->locationId);
            $this->fillFromModel($location);
        }
    }

    protected function fillFromModel(location $location)
    {
        $this->name = $location->name;
        $this->city_id = $location->city_id;
    }



    public function save()
    {
        // $this->resetErrorBag();

        // \dd();x
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:city,id',
        ]);


        if ($this->locationId) {
            $location = location::findOrFail($this->locationId);
            $location->update($validatedData);
            session()->flash('message', 'location updated successfully.');
        } else {
            location::create($validatedData);
            session()->flash('message', 'location created successfully.');
        }

        return redirect()->route('location.index');
    }
    public function render()
    {
        return view('livewire.locations-form');
    }
}
