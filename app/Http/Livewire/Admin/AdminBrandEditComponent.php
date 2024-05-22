<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;
class AdminBrandEditComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $brand_id;
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

    public function mount($brand_id)
    {
        $brand = Brand::find($brand_id);
        $this->brand_id = $brand->id;
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->image = $brand->image;
    }
    

    public function updateBrand()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);
        $brand = Brand::find($this->brand_id);
        $brand->name= $this->name;
        $brand->slug= $this->slug;
        if ($this->newimage) {
            // Delete old image if exists
            if ($brand->image && file_exists('img/products/brand/'.$brand->image)) {
                unlink('img/products/brand/'.$brand->image);
            }
            
            // Save new image
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('brand', $imageName);
            $brand->image = $imageName;
        }
    
        $brand->save();
        session()->flash('message', 'Đã cập nhật nhà phát hành thành công!');
    }
    public function render()
    {
        return view('livewire.admin.admin-brand-edit-component')->layout('layouts.guest') ;
    }
}
