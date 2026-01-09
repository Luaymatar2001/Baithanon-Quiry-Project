<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $FName;
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function mount($FName)
    {
        
        $this->FName = $FName ?? 'مستخدم';
    }
    public function render()
    {
        return view('livewire.navbar');
    }
}
