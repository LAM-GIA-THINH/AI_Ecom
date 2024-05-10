<?php

namespace App\Http\Livewire\Admin;
use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
class AdminBrandAddComponent extends Component
{
    public $name;
    public $slug;
    public function generateSlug()
    {
        $this->slug= Str::slug($this->name);
    }
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required'
        ]);
    }    
    public function storeBrand()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        Brand::create([
            'name' => $this->name,
            'slug' => $this->slug
        ]);

        session()->flash('message', 'Đã thêm thương hiệu thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-brand-add-component')->layout('layouts.guest');
    }
}
