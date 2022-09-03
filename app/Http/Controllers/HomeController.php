<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Merek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        $list_data = collect(Barang::latest()->get())->map(function ($response) {
            $rating = DB::select("SELECT round((SUM(c.rate)/ COUNT(c.rate)),0) as rating FROM detail_barangs a RIGHT JOIN detail_transaksis b ON a.id = b.detail_barang_id RIGHT JOIN komentars c ON b.id = c.detail_transaksi_id WHERE a.barang_id = " . $response->id);
            $rate = $rating[0]->rating !== null ? $rating[0]->rating : 1;
            $result = [
                "rating" => $rate,
                "barang" => $response
            ];
            return $result;
        });
        $data = [
            "title" => "Home",
            "list_cart" => $list_data,
            "list_merk" => Merek::get(),
            "title_cart" => "All Brands"
        ];
        return view("client.pages.contents.home", compact('data'));
    }
    public function display_by_merek($merek)
    {
        $list_data = collect(Merek::where("merek_name", "LIKE", $merek)->first()->barang)->map(function ($response) {
            $rating = DB::select("SELECT round((SUM(c.rate)/ COUNT(c.rate)),0) as rating FROM detail_barangs a RIGHT JOIN detail_transaksis b ON a.id = b.detail_barang_id RIGHT JOIN komentars c ON b.id = c.detail_transaksi_id WHERE a.barang_id = " . $response->id);
            $rate = $rating[0]->rating !== null ? $rating[0]->rating : 1;
            $result = [
                "rating" => $rate,
                "barang" => $response
            ];
            return $result;
        });
        $data = [
            "title" => "Home",
            "list_cart" => $list_data,
            "list_merk" => Merek::get(),
            "title_cart" => $merek
        ];
        return view("client.pages.contents.home", compact('data'));
    }

    public function dashboard()
    {
        $data = [
            "title" => "Dashboard",
        ];

        return view("admin.contents.dashboard.template", compact('data'));
    }
}
