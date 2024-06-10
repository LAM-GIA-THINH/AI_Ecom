<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AdminOrdersComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $filterorderStatus = '';
    public $filterPaymentStatus = '';

    public function render()
    {
        $user = Auth::user();
        if ($user->utype === 'GAR') {
            $orders = $this->filterOrders()
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } elseif ($user->utype === 'ADM') {
            $orders = $this->filterOrders()
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        } else {
            $orders = $this->filterOrders()
                ->where(function ($query) use ($user) {
                    $query->whereHas('orderItems.product', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->orWhere('shipper_id', $user->id);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(5);
        }
        return view('livewire.admin.admin-orders-component', ['orders' => $orders])->layout('layouts.guest');

    }

    public function filterOrders()
    {
        $query = Order::query();
    
        if ($this->search) {
            $query->where(function ($query) {
                $query->where('id', $this->search)
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            });
        }
    
        if ($this->filterorderStatus !== '') {
            $query->where('order_status', $this->filterorderStatus);
        }
    
        if ($this->filterPaymentStatus !== '') {
            $query->where('payment_status', $this->filterPaymentStatus);
        }
    
        return $query;
    }

    public function clearSearch()
    {
        $this->search = '';
    }
}
