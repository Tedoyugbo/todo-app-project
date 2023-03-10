<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.components.navbar');
    }

    public function userLogout()
    {
        Auth::logout();

        session()->flash('success','You are logged out Successfully!!');
        return redirect(route('login'));
    }
}
