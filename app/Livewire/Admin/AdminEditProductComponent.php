<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminEditProductComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;
    public $newimage;
    public $product_id;

    public function mount($product_slug)
    {
        $product = \App\Models\Product::where('slug',$product_slug)->first();
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->sale_price = $product->sale_price;
        $this->SKU = $product->SKU;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->category_id = $product->category_id;
        $this->product_id = $product->id;
    }

    public function generateslug()
    {
        $this->slug = Str::slug($this->name,"-");
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'slug' => 'required|unique:products',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'SKU' => 'required|string',
            'stock_status' => 'required|string',
            'quantity' => 'required|numeric',
            'newimage' => 'required|mimes:jpeg,png',
            'category_id' => 'required|numeric'
        ]);
    }

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required|string',
            'slug' => 'required|unique:products',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'SKU' => 'required|string',
            'stock_status' => 'required|string',
            'quantity' => 'required|numeric',
            'newimage' => 'required|mimes:jpeg,png',
            'category_id' => 'required|numeric'
        ]);
        $product = \App\Models\Product::find($this->product_id);
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price;
        $product->sale_price = $this->sale_price;
        $product->SKU = $this->SKU;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        if($this->newimage)
        {
            //unlink('assets/imgs/products/' . $product->image);
            $imageName = Carbon::now()->timestamp . '.' . $this->newimage->extension();
            $this->newimage->storeAs('products', $imageName);
            $product->image = $imageName;
        }
        $product->category_id = $this->category_id;
        $product->save();
        session()->flash('message', 'Product has been updated successfully!');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component',['categories' => $categories])->layout('layouts.base');
    }
}
