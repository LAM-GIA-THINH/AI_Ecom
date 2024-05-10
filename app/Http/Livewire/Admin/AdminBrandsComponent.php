<?php

namespace App\Http\Livewire\Admin;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class AdminBrandsComponent extends Component
{
    use WithPagination;
    protected $listeners = ['deleteBrand'];
    public $search = '';
    public function render()
    {
        $brands = Brand::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'ASC')
            ->paginate(5);
    
        return view('livewire.admin.admin-brands-component', ['brands' => $brands])->layout('layouts.guest');
    }
    public function deleteBrand($brandId)
    {
        $brand = Brand::find($brandId);
        if ($brand) {
            $brand->delete();
        }
    }
    public function clearSearch()
    {
        $this->search = '';
    }

}
