<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComponent extends Component
{
    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->dispatch('refreshComponent')->to('cart-count-component');
    }
    public function decreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->dispatch('refreshComponent')->to('cart-count-component');
    }

    public function removeItem($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        $this->dispatch('refreshComponent')->to('cart-count-component');
        session()->flash('success_message', 'Item has been removed');
    }

    public function removeAllItems()
    {
        Cart::instance('cart')->destroy();
        $this->dispatch('refreshComponent')->to('cart-count-component');
        session()->flash('success_message', 'All items has been removed');
    }
    
    public function switchToSaveForLater($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->dispatch('refreshComponent')->to('cart-count-component');
        session()->flash('success_message', 'Item has been saved for later');
    }

    public function moveToCart($rowId)
    {
        $item = Cart::instance('saveForLater')->get($rowId);
        Cart::instance('saveForLater')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->dispatch('refreshComponent')->to('cart-count-component');
        session()->flash('s_success_message', 'Item has been moved to cart');
    }

    public function deleteFromSaveForLater($rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);
        $this->dispatch('refreshComponent')->to('cart-count-component');
        session()->flash('s_success_message', 'Item has been deleted from save for later');
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
