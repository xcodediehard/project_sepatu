<?php

namespace App\Http\Controllers;

use App\Models\Balasan;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    //

    public function index($name)
    {
        $conf_value = str_replace("+", " ", $name);
        $cart_data = Barang::where("barang_name", "LIKE", $conf_value)->first();
        $comment = collect(DB::select("SELECT D.id, D.komentar,D.rate,F.nama FROM barangs A RIGHT JOIN detail_barangs B ON  A.id =B.barang_id RIGHT JOIN detail_transaksis C ON B.id=C.detail_barang_id RIGHT JOIN komentars D ON C.id=D.detail_transaksi_id LEFT JOIN transaksis E ON C.order_id = E.order_id LEFT JOIN pelanggans F ON E.pelanggan_id = F.id WHERE A.id = " . $cart_data->id))->map(function ($response) {
            $balasan = Balasan::where("komentar_id", "=", $response->id)->first();

            $result = [
                "komentar" => $response,
                "balasan" => $balasan != null ? $balasan : null
            ];

            return $result;
        });
        $data = [
            "title" => "Cart",
            "list_cart" => $cart_data,
            "list_comment" => $comment
        ];
        return view("client.cart.contents.home", compact("data"));
    }

    public function whistlist(Request $req)
    {
        $req->validate([
            'jumlah' => "required",
            'size' => "required|exists:detail_barangs,id",
        ]);
        $process = Keranjang::create([
            "pelanggan_id" => auth()->guard("client")->user()->id,
            "detail_barang_id" => $req->size,
            "jumlah" => $req->jumlah
        ]);
        if ($process) {
            session()->flash('success', 'Anda berhasil masukan ke keranjang');
            return redirect()->route('pages.keranjang_cart');
        } else {
            session()->flash('error', 'Anda gagal masukan ke keranjang');
            return redirect()->back();
        }
    }

    public function keranjang_cart()
    {
        $keranjang = collect(Keranjang::latest()->get())->map(function ($response) {
            $data_list = DB::select("SELECT (c.jumlah * b.barang_harga) as pembayaran,b.barang_gambar as gambar, b.barang_name as barang, c.jumlah, c.id as keranjang,IF(a.stok <= c.jumlah,'full','avail') as available_stok, a.size as detail_size, b.barang_harga as harga FROM keranjangs c LEFT JOIN detail_barangs a ON c.detail_barang_id = a.id LEFT JOIN barangs b ON a.barang_id = b.id WHERE a.id =" . $response->detail_barang_id);
            return $data_list[0];
        });
        $data = [
            "title" => "Keranjang",
            "list_cart" => $keranjang
        ];

        return view("client.cart.contents.keranjang", compact("data"));
    }


    public function delete_keranjang(Keranjang $keranjang)
    {
        $process = $keranjang->delete();

        if ($process) {
            session()->flash('success', 'Anda berhasil menghapus list keranjang');
            return redirect()->back();
        } else {
            session()->flash('error', 'Anda gagal menghapus list keranjang');
            return redirect()->back();
        }
    }
}
