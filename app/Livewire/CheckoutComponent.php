<?php

namespace App\Livewire;

use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public $ship_to_different_address;

    public $firstName;
    public $lastName;
    public $email;
    public $mobilePhone;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipCode;

    public $s_firstName;
    public $s_lastName;
    public $s_email;
    public $s_mobilePhone;
    public $s_line1;
    public $s_line2;
    public $s_city;
    public $s_province;
    public $s_country;
    public $s_zipCode;

    public $paymentMethod;
    public $thankyou;

    public function updated($fields)
    {
        $this->validateOnly($fields,[
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'mobilePhone' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipCode' => 'required',
            'paymentMethod' => 'required',
        ]);

        if($this->ship_to_different_address)
        {
            $this->validateOnly($fields,[
                's_firstName' => 'required',
                's_lastName' => 'required',
                's_email' => 'required|email',
                's_mobilePhone' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipCode' => 'required',
            ]);
        }
    }
    
    public function placeOrder()
    {
        $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'mobilePhone' => 'required|numeric',
            'line1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipCode' => 'required',
            'paymentMethod' => 'required',
        ]);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->firstName = $this->firstName;
        $order->lastName = $this->lastName;
        $order->email = $this->email;
        //$order->mobilePhone = $this->mobilePhone;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipCode = $this->zipCode;
        $order->status = 'ordered';
        $order->is_shipping_different = $this->ship_to_different_address ? 1:0;
        $order->save();

        foreach(Cart::instance('cart')->content() as $item)
        {
            $orderItem = new \App\Models\OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }

        if($this->ship_to_different_address)
        {
            $this->validate([
                's_firstName' => 'required',
                's_lastName' => 'required',
                's_email' => 'required|email',
                's_mobilePhone' => 'required|numeric',
                's_line1' => 'required',
                's_city' => 'required',
                's_province' => 'required',
                's_country' => 'required',
                's_zipCode' => 'required',
            ]);

            $shipping = new \App\Models\Shipping();
            $shipping->order_id = $order->id;
            $shipping->firstName = $this->s_firstName;
            $shipping->lastName = $this->s_lastName;
            $shipping->email = $this->s_email;
            $shipping->mobilePhone = $this->s_mobilePhone;
            $shipping->line1 = $this->s_line1;
            $shipping->line2 = $this->s_line2;
            $shipping->city = $this->s_city;
            $shipping->province = $this->s_province;
            $shipping->country = $this->s_country;
            $shipping->zipCode = $this->s_zipCode;
            $shipping->save();
        }

        if($this->paymentMethod == 'cod')
        {
            $transaction = new \App\Models\Transaction();
            $transaction->user_id = Auth::user()->id;
            $transaction->order_id = $order->id;
            $transaction->mode = 'cod';
            $transaction->status = 'pending';
            $transaction->save();
        }

        $this->thankyou = true;
        Cart::instance('cart')->destroy();
        session()->forget('checkout');
    }

    public function verifyForCheckout()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
        elseif ($this->thankyou) {
            return redirect()->route('thankyou');
        }
        elseif (!session()->get('checkout')) {
            return redirect()->route('product.cart');
        }
    }

    public function render()
    {
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
