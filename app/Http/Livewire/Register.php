<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    // declare form input variables
    public $first_name;

    public $last_name;

    public $email;

    public $password;

    public $confirmPass;

    public $error;

    //set form validation rules
    protected $rules = [
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|same:confirmPass',
        'confirmPass' => 'required'
    ];

    public function render()
    {
        return view('livewire.register');
    }

    public function handleSubmit()
    {
        //validation
        $this->validate();

        //hash password
        $hashPass = Hash::make($this->password);

        //register user
        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $hashPass
        ]);

        if($user){
            //flash success message
            $this->dispatchBrowserEvent('toast-success', ['message' => 'You are Registered Successfully']);
            //if user successfully created redirect to login page
            return redirect(route("login"));
        }
        // else return error
        $this->error = "Something went wrong";
        $this->dispatchBrowserEvent('toast-error', ['message' => $this->error]);
        return;
    }
}
