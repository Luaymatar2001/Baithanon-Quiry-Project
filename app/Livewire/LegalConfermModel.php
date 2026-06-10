<?php

namespace App\Livewire;

use Livewire\Component;

class LegalConfermModel extends Component
{
    public $household;
    public $legalConfirm = false;
    public function mount($household)
    {
        $this->household = $household;
        $this->legalConfirm = $household->legal_confirmation;
    }
        public function updatedLegalConfirm($value)
    {
        $this->legalConfirm = $value;
        //update household record
        $this->household->legal_confirmation = $value;
        $this->household->save();
        

    }

    public function render()
    {
        return view('livewire.legal-conferm-model');
    }
}
