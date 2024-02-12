<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    use WithPagination;


    public function deleteCategory($category_id)
    {
        $category = Category::find($category_id);
        $category->delete();
        session()->flash('message', 'Category has been deleted successfully');
    }

    public function render()
    {
        $categories = Category::paginate(5);
        return view('livewire.admin.admin-category-component',['categories' => $categories])->layout('layouts.base');
    }
}
