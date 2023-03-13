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
            //flash success message with toaster
            $this->dispatchBrowserEvent('toast-success', ['message' => 'You are logged in successfully']);
            return redirect(route('home'));
        }else{
            $this->email = '';
            $this->password = '';
            $this->error = "Invalid Credentials";
            //flash error message with toaster
            $this->dispatchBrowserEvent('toast-error', ['message' => $this->error]);
        }
    }
}
