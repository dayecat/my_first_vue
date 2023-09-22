<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function shopping_cart(Request $request)
    {
        $user = $request->user();

        $carts = Cart::select('id','product_id','user_id',)->where('user_id', $user->id)->with(['product:id,img_path,name,price','product.productImg'])->get();

        return Inertia::render('Frontend/ShoppingCart', ['response' => rtFormat($carts)]);
    }
}
