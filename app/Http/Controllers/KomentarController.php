<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomentarController extends Controller
{
    //
    public function index()
    {
        $list_komentar = DB::select('SELECT a.id as id_komentar, a.*, d.*, f.barang_name FROM  komentars a LEFT JOIN detail_transaksis b ON a.detail_transaksi_id = b.id LEFT JOIN transaksis c ON b.order_id = c.order_id LEFT JOIN pelanggans d ON c.pelanggan_id = d.id LEFT JOIN detail_barangs e ON b.detail_barang_id = e.id LEFT JOIN barangs f ON e.barang_id = f.id');
        $data = [
            "title" => "Komentar",
            "list" => $list_komentar
        ];
        return view("admin.contents.komentar.template", compact('data'));
    }
}
