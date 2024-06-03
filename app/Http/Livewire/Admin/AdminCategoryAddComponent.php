<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Category;
use Livewire\WithFileUploads;
use Carbon\Carbon;
class AdminCategoryAddComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $image;
    public function generateSlug()
    {
        $this->slug= Str::slug($this->name);
    }
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
    }    
    public function storeCategory()
    {
        $this->validate([
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        $category = new Category();
        $category->name = $this->name;
        $category->slug = Str::slug($this->slug);
        $imageName=Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('category', $imageName);
        $category->image = $imageName;
        $category->save();
        $this->emit('showSuccessMessage');

    }
    public function render()
    {
        return view('livewire.admin.admin-category-add-component')->layout('layouts.guest') ;
    }

}
