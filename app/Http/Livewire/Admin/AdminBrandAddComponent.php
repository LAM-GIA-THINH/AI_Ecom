<?php

namespace App\Http\Livewire\Admin;
use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
class AdminBrandAddComponent extends Component
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
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
    }    
    public function storeBrand()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        $brand = new Brand();
        $brand->name = $this->name;
        $brand->slug = Str::slug($this->slug);
        $imageName=Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('brand', $imageName);
        $brand->image = $imageName;
        $brand->save();
        session()->flash('message', 'Đã thêm thương hiệu thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-brand-add-component')->layout('layouts.guest');
    }
}
