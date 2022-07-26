<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    //

    public function index($name)
    {
        $conf_value = str_replace("+", " ", $name);
        $cart_data = Barang::where("barang_name", "LIKE", $conf_value)->first();
        $data = [
            "title" => "Cart",
            "list_cart" => $cart_data
        ];
        return view("client.cart.contents.home", compact("data"));
    }
}
