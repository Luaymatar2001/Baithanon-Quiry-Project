<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Governorate;
use App\Models\city;
use App\Models\governorates;
use App\Models\location;

class LocationSelector extends Component
{
    public $governorate_id;
    public $city_id;
    public $location_id;
    public $selectedGovernorate;
    public $selectedCity;
    public $selectedLocation;

    public $governorateMessage ;
    public $citiesMessage ;
    public  $locationsMessage;


    public $governorates = [];
    public $cities = [];
    public $locations = [];

    public function mount($governorateMessage = null, $citiesMessage = null, $locationsMessage = null , $selectedGovernorate = null, $selectedCity = null, $selectedLocation = null)
    {
        $this->governorates = governorates::all();
        $this->governorateMessage = $governorateMessage;
        $this->citiesMessage = $citiesMessage;
        $this->locationsMessage = $locationsMessage;
        // $this->governorate_id = $selectedGovernorate;
        // $this->city_id = $selectedCity;
        // $this->location_id = $selectedLocation;
    }

    // عند تغيير المحافظة
    public function updatedGovernorateId($value)
    {

        $this->cities = city::where('governorateId', $value)->get();
        $this->city_id = null;
        $this->locations = [];
    }

    // عند تغيير المدينة
    public function updatedCityId($value)
    {

        $this->locations = location::where('city_id', $value)->get();
        $this->location_id = null;
    }

    public function render()
    {
        return view('livewire.location-selector');
    }
}
