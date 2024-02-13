<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
    use WithPagination;


    public function deleteProduct($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();
        session()->flash('message', 'Product has been deleted successfully');
    }

    public function render()
    {
        $products = \App\Models\Product::paginate(10);
        return view('livewire.admin.admin-product-component', ['products' => $products])->layout('layouts.base');
    }
}
