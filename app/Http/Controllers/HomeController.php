<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Merek;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $data = [
            "title" => "Home",
            "list_cart" => Barang::latest()->get(),
            "list_merk" => Merek::get(),
            "title_cart" => "All Brands"
        ];
        return view("client.pages.contents.home", compact('data'));
    }
    public function display_by_merek($merek)
    {
        $data = [
            "title" => "Home",
            "list_cart" => Merek::where("merek_name", "LIKE", $merek)->first()->barang,
            "list_merk" => Merek::get(),
            "title_cart" => $merek
        ];
        return view("client.pages.contents.home", compact('data'));
    }
}
