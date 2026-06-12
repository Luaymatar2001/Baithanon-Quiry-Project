<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Governorate;
use App\Models\City;
use App\Models\governorates;
use App\Models\location;

class LocationSelector extends Component
{
    public $governorate_id;
    public $city_id;
    public $location_id;

    public $governorateMessage;
    public $citiesMessage;
    public $locationsMessage;

    public $governorates = [];
    public $cities = [];
    public $locations = [];

    public function mount($governorateMessage = null, $citiesMessage = null, $locationsMessage = null, $selectedGovernorate = null, $selectedCity = null, $selectedLocation = null)
    {
        // الرسائل
        $this->governorateMessage = $governorateMessage;
        $this->citiesMessage = $citiesMessage;
        $this->locationsMessage = $locationsMessage;

        // القيم المختارة
        $this->governorate_id = $selectedGovernorate;
        $this->city_id = $selectedCity;
        $this->location_id = $selectedLocation;

        // جلب كل المحافظات
        $this->governorates = governorates::all();

        // إذا عندنا قيمة محافظة محددة، جلب المدن
        if ($this->governorate_id) {
            $this->cities = city::where('governorateId', $this->governorate_id)->get();
        }

        // إذا عندنا قيمة مدينة محددة، جلب المناطق
        if ($this->city_id) {
            $this->locations = location::where('city_id', $this->city_id)->get();
        }
    }

    public function updatedGovernorateId($value)
    {
        $this->cities = city::where('governorateId', $value)->get();
        $this->city_id = null;
        $this->location_id = null;
        $this->locations = [];
    }

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
