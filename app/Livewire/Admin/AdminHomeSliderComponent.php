<?php

namespace App\Livewire\Admin;

use App\Models\HomeSlider;
use Livewire\Component;

class AdminHomeSliderComponent extends Component
{
    public function deleteSlide($slide_id)
    {
        $slide = HomeSlider::find($slide_id);
        $slide->delete();
        session()->flash('message', 'Slide has been deleted successfully!');
    }
    
    public function render()
    {
        $sliders = HomeSlider::all();
        return view('livewire.admin.admin-home-slider-component', ['sliders' => $sliders])->layout('layouts.base');
    }
}
