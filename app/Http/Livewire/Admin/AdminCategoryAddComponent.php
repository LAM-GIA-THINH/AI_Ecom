<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;
class AdminCategoryAddComponent extends Component
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
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories'
        ]);
    }    
    public function storeCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories'
        ]);

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug
        ]);

        session()->flash('message', 'Đã thêm danh mục thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-category-add-component')->layout('layouts.guest') ;
    }

}
