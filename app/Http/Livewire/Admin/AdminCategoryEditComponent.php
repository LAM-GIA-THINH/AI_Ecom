<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;
class AdminCategoryEditComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $category_id;
    public $newimage;
    public $image;
    public function generateSlug()
    {
        $this->slug= Str::slug($this->name);
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required',
            'newimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
    }    

    public function mount($category_id)
    {
        $category = Category::find($category_id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug= $category->slug;
        $this->image = $category->image;
    }

    public function updateCategory()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);
        $category = Category::find($this->category_id);
        $category->name= $this->name;
        $category->slug= $this->slug;
        if ($this->newimage) {
            // Delete old image if exists
            if ($category->image && file_exists('img/products/category/'.$category->image)) {
                unlink('img/products/category/'.$category->image);
            }
            
            // Save new image
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('category', $imageName);
            $category->image = $imageName;
        }
        $category->save();
        session()->flash('message', 'Đã cập nhật danh mục thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-category-edit-component')->layout('layouts.guest') ;
    }
}
