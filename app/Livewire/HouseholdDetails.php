<?php

namespace App\Livewire;

use App\Models\city;
use App\Models\head_children;
use App\Models\household;
use App\Models\partner;
use Livewire\Component;

class HouseholdDetails extends Component
{
    public $household;
    public $legalConfirm = false;
    public $editMember;

    public function mount()
    {
        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $this->household = household::with(['partner', 'children'])->findOrFail($householdId);

        $this->legalConfirm = (bool) $this->household->legal_confirmation;
    }

    public $editMemberData = null;

    public function openEditMember($memberId, $type)
    {

        if ($type === 'partner') {
            $member = partner::find($memberId); // جدول partner (أنثى/زوجة)
        } else {
            $member = head_children::find($memberId); // جدول head_children (ذكر)
        }


        $this->editMemberData = $member->toArray();
        $this->editMemberData['member_type'] = $type; // نبعثه للـ JS عشان يعرف

        $this->dispatch('openEditPopup', member: $this->editMemberData);
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
