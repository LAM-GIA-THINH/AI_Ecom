<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserPaymentResultComponent extends Component
{
    public function mount()
    {
        $this->message = session('message');
        $this->orderId = session('order_id');
        $this->messageType = session('messageType');
    }
    public function render()
    {
        return view('livewire.user.user-payment-result-component', ['message' => $this->message, 'messageType' => $this->messageType, 'order_id' => $this->orderId]);
    }
}
