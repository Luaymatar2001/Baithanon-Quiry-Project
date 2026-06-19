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
    public $desc_health_status;
    public $alternative_mobile_number;
    public $international_number_mobile;
    public $residence_location;
    public $residence_status;
    public $missing_persons;
    public $missing_info;
    public $level_of_education;
    public $reason_leaving;
    public $current_location;
    public $expected_salary;
    public $Type_of_housing;


    public $cities = [];
    public $locations = [];
    public $governorates = [];



    public function mount($householdId = null)
    {

        $this->householdId = $householdId;

        $this->cities = city::all();
        $this->governorates = governorates::all();
        $this->locations = location::all();

        if ($this->householdId) {
            $household = household::findOrFail($this->householdId);
            $this->fillFromModel($household);
        }
    }

    protected function fillFromModel(household $household)
    {

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
        $this->desc_health_status = $household->desc_health_status;
        $this->alternative_mobile_number = $household->alternative_mobile_number;
        $this->international_number_mobile = $household->international_number_mobile;
        // $this->residence_location = $household->residence_location;
        // $this->residence_status = $household->residence_status;
        $this->missing_persons = $household->missing_persons  ?? 0;
        $this->missing_info = $household->missing_info;
        $this->level_of_education = $household->level_of_education;
        $this->Type_of_housing = $household->Type_of_housing;
        $this->current_location = $household->current_location;
        $this->expected_salary = $household->expected_salary;
        $this->Notes = $household->Notes;
    }

    public function updatedGovernorateId()
    {
        $this->loadLocations();
        // $this->location_id = null;
    }

    public function updatedCityId()
    {
        $this->loadLocations();
        // $this->location_id = null;
    }

    private function loadLocations()
    {
        if (!$this->cityId) {
            $this->locations = [];
            return;
        }

        $city = city::find($this->cityId);

        if (!$city) {
            $this->locations = [];
            return;
        }

        // لا تمسح القيم
        $this->governorate_id = $city->governorateId;

        $this->locations = location::where('city_id', $this->cityId)->get();
    }



    public function save()
    {

        $validatedData = $this->validate([

            'PersonId' => [
                'required',
                Rule::unique('heads_households', 'PersonId')->ignore($this->householdId),
            ],
            'FName' => 'sometimes|string|max:255',
            'SName' => 'nullable|string|max:255',
            'TName' => 'nullable|string|max:255',
            'LName' => 'sometimes|string|max:255',
            'BirthDate' => 'nullable|date',
            'Gender' => 'sometimes|in:ذكر,أنثى',
            'Phone_Number' => [
                'nullable',
                'digits:10',
                'regex:/^(059|056)\d{7}$/',
            ],
            'alternative_mobile_number' => [
                'nullable',
                'digits:10',
                'regex:/^(059|056)\d{7}$/',
                'different:Phone_Number',
            ],
            'num_Family_Members' => 'nullable|integer|min:1',
            'legal_confirmation' => 'boolean',
            'expected_salary' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'cityId' => 'nullable|exists:city,id',
            'location_id' => 'nullable|exists:locations,id',
            'governorate_id' => 'nullable|exists:governorates,id',
            'Date_partner_martyrdom' => 'nullable|date',
            'health_Status' => 'nullable|string|max:255',
            'Sources_income' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'Notes' => 'nullable|string',
            'desc_health_status' => 'nullable|string|max:255',
            'international_number_mobile' => [
                'nullable',
            ],
            // 'residence_location' => 'required|string|in:0,1',
            // 'residence_status' => 'required|string|in:0,1',
            'missing_persons' => 'nullable|integer|in:0,1,2',
            'missing_info' => 'nullable|string|max:255',
            'level_of_education' => 'nullable|string|max:255',
            'Type_of_housing' => 'nullable|string|max:255',
            'reason_leaving' => 'nullable|integer|in:0,1,2,3,',
            'current_location' => 'nullable|string|max:255',
        ], [
            'PersonId.required' => 'رقم الهوية مطلوب',
            'PersonId.unique' => 'رقم الهوية موجود مسبقاً',

            'FName.string' => 'الاسم الأول يجب أن يكون نصاً',
            'FName.max' => 'الاسم الأول لا يجب أن يزيد عن 255 حرفاً',

            'SName.string' => 'اسم الأب يجب أن يكون نصاً',
            'SName.max' => 'اسم الأب لا يجب أن يزيد عن 255 حرفاً',

            'TName.string' => 'اسم الجد يجب أن يكون نصاً',
            'TName.max' => 'اسم الجد لا يجب أن يزيد عن 255 حرفاً',

            'LName.string' => 'اسم العائلة يجب أن يكون نصاً',
            'LName.max' => 'اسم العائلة لا يجب أن يزيد عن 255 حرفاً',

            'BirthDate.date' => 'تاريخ الميلاد غير صحيح',

            'Gender.in' => 'يجب اختيار الجنس بشكل صحيح',

            'Phone_Number.numeric' => 'رقم الجوال يجب أن يحتوي على أرقام فقط',
            'Phone_Number.regex' => 'رقم الجوال يجب أن يبدأ بـ 059 أو 056 ويتكون من 10 أرقام',

            'alternative_mobile_number.numeric' => 'رقم الجوال البديل يجب أن يحتوي على أرقام فقط',
            'alternative_mobile_number.regex' => 'رقم الجوال البديل غير صحيح',
            'alternative_mobile_number.different' => 'رقم الجوال البديل يجب أن يكون مختلفاً عن رقم الجوال الأساسي',

            'num_Family_Members.integer' => 'عدد أفراد الأسرة يجب أن يكون رقماً صحيحاً',
            'num_Family_Members.min' => 'عدد أفراد الأسرة يجب أن يكون أكبر من صفر',

            'expected_salary.numeric' => 'الراتب المتوقع يجب أن يكون رقماً',
            'expected_salary.integer' => 'الراتب المتوقع يجب أن يكون رقماً صحيحاً',
            'expected_salary.min' => 'الراتب المتوقع لا يمكن أن يكون أقل من صفر',

            'status.max' => 'الحالة الاجتماعية طويلة جداً',

            'cityId.exists' => 'المدينة المختارة غير موجودة',

            'location_id.exists' => 'المنطقة المختارة غير موجودة',

            'governorate_id.exists' => 'المحافظة المختارة غير موجودة',

            'Date_partner_martyrdom.date' => 'تاريخ الاستشهاد غير صحيح',

            'health_Status.max' => 'الحالة الصحية طويلة جداً',

            'Sources_income.max' => 'مصدر الدخل طويل جداً',

            'address.max' => 'العنوان طويل جداً',

            'desc_health_status.max' => 'وصف الحالة الصحية طويل جداً',

            'international_number_mobile.numeric' => 'رقم التواصل الدولي يجب أن يحتوي على أرقام فقط',
            'international_number_mobile.regex' => 'رقم التواصل الدولي غير صحيح',

            'residence_location.required' => 'مكان الإقامة مطلوب',
            'residence_location.in' => 'القيمة المدخلة خاطئة',

            // 'residence_status.required' => 'حالة الإقامة مطلوبة',
            // 'residence_status.in' => 'القيمة المدخلة خاطئة',

            'missing_persons.integer' => 'عدد المفقودين يجب أن يكون رقماً',
            'missing_persons.in' => 'القيمة المدخلة خاطئة',

            'missing_info.max' => 'بيانات المفقودين طويلة جداً',

            'level_of_education.max' => 'مستوى التعليم طويل جداً',

            'Type_of_housing.max' => 'نوع السكن طويل جداً',

            'reason_leaving.integer' => 'سبب الخروج غير صحيح',
            'reason_leaving.in' => 'سبب الخروج غير صحيح',

            'current_location.max' => 'العنوان الحالي طويل جداً',
        ]);

        $validatedData['missing_persons'] = $validatedData['missing_persons'] ?? 0;

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
