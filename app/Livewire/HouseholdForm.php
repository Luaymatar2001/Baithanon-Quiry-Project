<?php

namespace App\Livewire;

use App\Models\household;
use App\Models\city;
use App\Models\location;
use App\Models\governorates;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HouseholdForm extends Component
{
    public $householdId;
    public $PersonId;
    public $FName;
    public $SName;
    public $TName;
    public $LName;
    public $BirthDate;
    public $Gender;
    public $Phone_Number;
    public $num_Family_Members;
    public $legal_confirmation = false;
    public $status;
    public $cityId;
    public $location_id;
    public $governorate_id;
    public $Date_partner_martyrdom;
    public $health_Status;
    public $Sources_income;
    public $address;
    public $Notes;

    public $cities = [];
    public $locations = [];
    public $governorates = [];

    public function mount($householdId = null)
    {
        $this->householdId = null;
        $this->cities = city::all();
        $this->governorates = governorates::all();
        $this->locations = location::all();

        if ($householdId) {
            $household = household::findOrFail($householdId);
            $this->householdId = $household->id;
            $this->PersonId = $household->PersonId;
            $this->FName = $household->FName;
            $this->SName = $household->SName;
            $this->TName = $household->TName;
            $this->LName = $household->LName;
            $this->BirthDate = $household->BirthDate;
            $this->Gender = $household->Gender;
            $this->Phone_Number = $household->Phone_Number;
            $this->num_Family_Members = $household->num_Family_Members;
            $this->legal_confirmation = $household->legal_confirmation;
            $this->status = $household->status;
            $this->cityId = $household->cityId;
            $this->location_id = $household->location_id;
            $this->governorate_id = $household->governorate_id;
            $this->Date_partner_martyrdom = $household->Date_partner_martyrdom;
            $this->health_Status = $household->health_Status;
            $this->Sources_income = $household->Sources_income;
            $this->address = $household->address;
            $this->Notes = $household->Notes;

            $this->loadLocations();
        }
    }

    public function updatedGovernorateId()
    {
        $this->loadLocations();
        $this->location_id = null;
    }

    public function updatedCityId()
    {
        $this->loadLocations();
        $this->location_id = null;
    }

    private function loadLocations()
    {
        if (!$this->cityId) {
            $this->locations = [];
            $this->governorate_id = null;
            return;
        }

        // جلب المدينة
        $city = City::find($this->cityId);

        if (!$city) {
            $this->locations = [];
            return;
        }

        // تعيين المحافظة من المدينة
        $this->governorate_id = $city->governorate_id;

        // جلب المواقع (حسب city فقط)
        $this->locations = Location::where('city_id', $this->cityId)->get();
    }


    public function save()
    {
        $validatedData = $this->validate([

            'PersonId' => [
                'required',
                Rule::unique('heads_households', 'PersonId')->ignore($this->householdId),
            ],
            'FName' => 'required|string|max:255',
            'SName' => 'nullable|string|max:255',
            'TName' => 'nullable|string|max:255',
            'LName' => 'required|string|max:255',
            'BirthDate' => 'nullable|date',
            'Gender' => 'required|in:ذكر,أنثى',
            'Phone_Number' => 'nullable|string|max:20',
            'num_Family_Members' => 'nullable|integer|min:1',
            'legal_confirmation' => 'boolean',
            'status' => 'nullable|string|max:255',
            'cityId' => 'nullable|exists:city,id',
            'location_id' => 'nullable|exists:locations,id',
            'governorate_id' => 'nullable|exists:governorates,id',
            'Date_partner_martyrdom' => 'nullable|date',
            'health_Status' => 'nullable|string|max:255',
            'Sources_income' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'Notes' => 'nullable|string',
        ]);



        if ($this->householdId) {
            $household = household::findOrFail($this->householdId);
            $household->update($validatedData);
            session()->flash('message', 'Household updated successfully.');
        } else {
            household::create($validatedData);
            session()->flash('message', 'Household created successfully.');
        }

        return redirect()->route('headhousehold.index');
    }

    public function render()
    {
        return view('livewire.household-form');
    }
}
