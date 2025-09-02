<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        return view('wishlist', compact('items'));
    }
    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function remove_item($rowID)
    {
        Cart::instance('wishlist')->remove($rowID);
        return redirect()->back();
    }

    public function empty_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->route('wishlist.index');
    }

    public function move_to_cart($rowID)
    {
        $item = Cart::instance('wishlist')->get($rowID);
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Models\Product');
        Cart::instance('wishlist')->remove($rowID);
        return redirect()->back();
    }
}
