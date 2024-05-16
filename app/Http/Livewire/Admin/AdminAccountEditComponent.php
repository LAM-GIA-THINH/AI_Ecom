<?php

namespace App\Http\Livewire\Admin;
use App\Models\User;
use Livewire\Component;

class AdminAccountEditComponent extends Component
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

    public function mount($account_id)
    {
        $account = User::find($account_id);
        $this->account_id = $account->id;
        $this->name = $account->name;
        $this->email = $account->email;
        $this->phone = $account->phone;
        $this->password = $account->password;
        $this->utype = $account->utype;
       
    }
    
    public function updateAcc()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password'=> 'required',
            'utype' => 'required'
        ]);
        $account = User::find($this->account_id);
        $account->name= $this->name;
        $account->email= $this->email;
        $account->phone= $this->phone;
        $account->password= bcrypt($this->password);
        $account->utype= $this->utype;
        $account->save();
        session()->flash('message', 'Đã cập nhật tài khoản hành thành công!');
    }
    public function render()
    {
        
        return view('livewire.admin.admin-account-edit-component')->layout('layouts.guest');
    }
}
