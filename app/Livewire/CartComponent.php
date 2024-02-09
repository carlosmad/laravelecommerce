<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
    }
    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId, $qty);
    }

    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'Item has been removed');
    }

    public function removeAllItems()
    {
        Cart::destroy();
        session()->flash('success_message', 'All items has been removed');
    }
    
    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
