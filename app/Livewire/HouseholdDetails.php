<?php

namespace App\Livewire;

use App\Models\city;
use App\Models\household;
use Livewire\Component;

class HouseholdDetails extends Component
{
    public $household;
    public $legalConfirm = false;

    public function mount()
    {
        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $this->household = household::with(['partner', 'children'])->findOrFail($householdId);
      
        $this->legalConfirm =(bool) $this->household->legal_confirmation ;

    }

    // legalConfirm

    public function updatedLegalConfirm($value)
    {
        $this->legalConfirm = $value;
        //update household record
        $this->household->legal_confirmation = $value;
        $this->household->save();
    }

    public function render()
    {
        return view('livewire.household-details');
    }
}
