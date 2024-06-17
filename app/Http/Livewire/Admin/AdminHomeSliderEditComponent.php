<?php

namespace App\Http\Livewire\Admin;
use App\Models\HomeSlider;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminHomeSliderEditComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $top_title;
    public $sub_title;
    public $offer;
    public $link;
    public $type;
    public $image;
    public $slide_id;
    public $newimage;
    public function mount($slide_id)
    {
        $slide = HomeSlider::find($slide_id);
        $this->top_title = $slide->top_title;
        $this->title = $slide->title;
        $this->sub_title = $slide->sub_title;
        $this->offer = $slide->offer;
        $this->link = $slide->link;
        $this->type = $slide->type;
        $this->image = $slide->image;
        $this->slider_id = $slide->id;
    }
    public function updateSlide()
    {
        $this->validate([
            'title' => 'required',
            'top_title' => 'required',
            'sub_title' => 'required',
            'offer' => 'required',
            'link' => 'required',
            'type' => 'required',
            'newimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
    
        $slide = HomeSlider::find($this->slide_id);
        $slide->title = $this->title;
        $slide->top_title = $this->top_title;
        $slide->sub_title = $this->sub_title;
        $slide->offer = $this->offer;
        $slide->link = $this->link;
        $slide->type = $this->type;
    
        if ($this->newimage) {
            // Delete old image if exists
            if ($slide->image && file_exists('img/products/slider/'.$slide->image)) {
                unlink('img/products/slider/'.$slide->image);
            }
            
            // Save new image
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('slider', $imageName);
            $slide->image = $imageName;
        }
    
        $slide->save();
        $this->emit('showSuccessMessage');
    }
    
    public function render()
    {
        return view('livewire.admin.admin-home-slider-edit-component')->layout('layouts.guest');
    }
}
