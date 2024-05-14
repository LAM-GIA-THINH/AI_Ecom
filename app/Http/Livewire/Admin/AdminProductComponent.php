<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AdminProductComponent extends Component
{
    use WithPagination;
    public $product_id;
    public $search = '';
    public $filterStockStatus = '';
    protected $listeners = ['deleteProduct'];

    public function render()
    {
        $user = Auth::user();
        $products = $this->filterStockStatus()
            ->where('user_id', $user->id)
            ->orderBy('id', 'ASC')
            ->paginate(5);

        return view('livewire.admin.admin-product-component', ['products' => $products])->layout('layouts.guest');
    }

    public function filterStockStatus()
    {
        $query = Product::where('name', 'like', '%' . $this->search . '%');
    
        if ($this->filterStockStatus === 'in_stock') {
            $query->where('quantity', '>', 0);
        } elseif ($this->filterStockStatus === 'out_of_stock') {
            $query->where('quantity', '=', 0);
        }
    
        return $query;
    }
    public function clearSearch()
    {
        $this->search = '';
    }
    public function deleteProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
        }
    }
}