<?php

namespace App\Http\Livewire\Admin;
use App\Models\HomeSlider;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Livewire\WithFileUploads;
class AdminHomeSliderAddComponent extends Component
{
    use WithFileUploads;
    public $title;
    public $top_title;
    public $sub_title;
    public $offer;
    public $link;
    public $type;
    public $image;
    public function addSlide()
    {
        $this->validate([
            'title' => 'required',
            'top_title' => 'required',
            'sub_title' => 'required',
            'offer' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'type' => 'required'
        ]);

        $slide = new HomeSlider();
        $slide->top_title = $this->top_title;
        $slide->title = $this->title;
        $slide->sub_title = $this->sub_title;
        $slide->offer = $this->offer;
        $slide->link = $this->link;
        $slide->type = $this->type;
        $imageName=Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('slider', $imageName);
        $slide->image = $imageName;
        $slide->save();
        $this->emit('showSuccessMessage');
    }
    public function render()
    {
        return view('livewire.admin.admin-home-slider-add-component')->layout('layouts.guest');
    }
}
