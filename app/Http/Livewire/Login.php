<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;

    public $password;

    public $error;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8'
    ];

    public function render()
    {
        return view('livewire.login');
    }

    public function handleSubmit()
    {
        $this->validate();
        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])){
            session()->flash('success','You are logged in successfully');
            if (Auth::user()->role_id == User::ADMIN) {
                return redirect(route('admin.dashboard'));
            }
            return redirect(route('home'));
        }else{
            $this->email = '';
            $this->password = '';
            return $this->error = "Invalid Credentials";
        }
    }
}
