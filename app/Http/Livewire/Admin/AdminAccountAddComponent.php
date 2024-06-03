<?php

namespace App\Http\Livewire\Admin;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
class AdminAccountAddComponent extends Component
{
    public $name;
    public $email;
    public $password;

    public $utype;

    public $phone;


    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password'=> 'required',
            'utype' => 'required'
        ]);
    }    
    public function storeAcc()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password'=> 'required',
            'utype' => 'required'
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone'=> $this->phone,
            'password'=> bcrypt($this->password),
            'utype' => $this->utype
        ]);

        $this->emit('showSuccessMessage');
    }
    public function render()
    {
        return view('livewire.admin.admin-account-add-component')->layout('layouts.guest');
    }
}
