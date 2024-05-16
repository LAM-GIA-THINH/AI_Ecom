<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrdersComponent extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy("created_at", "desc")->paginate(5);
        return view('livewire.user.user-orders-component', ['orders' => $orders]);
    }
}
