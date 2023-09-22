<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontController extends Controller
{
    public function home() {
        $products = Product::orderBy('id', 'desc')->where('public', 1)->get();

        return Inertia::render('Frontend/Index', [
            'response' => rtFormat($products),
        ]);
    }
    public function addCart(Request $request) {
        $request->validate([
            'id' => 'required|numeric|exists:products,id',
            'qty' => 'required|numeric|min:1',
        ]);

        Cart::creat([
            'product_id' => $request->id,
            'qty' => $request->qty,
            'user_id' => $request->user()->id,

        ]);

        $cart = Cart::where('product_id', $request->id)->where('user_id', $request->user()->id)->first();

        if($cart) {
            $cart->update([
                'qty' => $cart->qty +$request->qty,
            ]);
        } else {
            $cart = Cart::create([
                'product_id' => $request->id,
                'qty' => $request->qty,
                'user_id' => $request->user()->id,
            ]);
    }

    return back()->with(['message' => rtFormat($cart->id)]);

}
}
