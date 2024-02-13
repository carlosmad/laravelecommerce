<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\HomeCategory;
use Livewire\Component;

class AdminHomeCategoryComponent extends Component
{
    public $selected_categories = [];
    public $no_of_products;

    public function mount()
    {
        $categories = HomeCategory::find(1);
        $this->selected_categories = explode(',', $categories->sel_categories);
        $this->no_of_products = $categories->no_of_products;
    }

    public function updateHomeCategory()
    {
        $category = HomeCategory::find(1);
        $category->sel_categories = implode(', ', $this->selected_categories);
        $category->no_of_products = $this->no_of_products;
        $category->save();
        session()->flash('message', 'Home Category has been updated successfully!');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-home-category-component',['categories' => $categories])->layout('layouts.base');
    }
}
