<?php

namespace App\Http\Livewire\Admin;
use Livewire\WithPagination;
use App\Models\HomeSlider;
use Livewire\Component;

class AdminHomeSliderComponent extends Component
{
    use WithPagination;
    protected $listeners = ['deleteSlide'];
    public function render()
    {
        $slides= HomeSlider::orderBy("created_at","desc")->get();
        return view('livewire.admin.admin-home-slider-component',['slides'=>$slides])->layout('layouts.guest');
    }
    public function deleteSlide($sliderId)
    {
        $slider = HomeSlider::find($sliderId);
        if ($slider) {
            $slider->delete();
        }
    }
    public function clearSearch()
    {
        $this->search = '';
    }
}
