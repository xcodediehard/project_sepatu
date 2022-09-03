<?php

namespace App\Http\Controllers;

use App\Models\Balasan;
use App\Models\Komentar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomentarController extends Controller
{
    //
    public function index()
    {
        $list_komentar = DB::select('SELECT a.status as status, a.id as id,a.id as id_komentar, a.komentar as komentar, a.rate as rate, f.barang_name as barang,d.nama as name FROM  komentars a LEFT JOIN detail_transaksis b ON a.detail_transaksi_id = b.id LEFT JOIN transaksis c ON b.order_id = c.order_id LEFT JOIN pelanggans d ON c.pelanggan_id = d.id LEFT JOIN detail_barangs e ON b.detail_barang_id = e.id LEFT JOIN barangs f ON e.barang_id = f.id');
        $data = [
            "title" => "Komentar",
            "list" => $list_komentar
        ];
        return view("admin.contents.komentar.template", compact('data'));
    }


    public function send_comment(Request $request)
    {;
        $request->validate([
            "barang.*" => "required|exists:detail_transaksis,id",
            "rating_score" => "required",
            "comment" => "required",
            "comentar_number" => "exists:transaksis,order_id"
        ]);

        foreach ($request->barang as $key => $value) {
            Komentar::create([
                "detail_transaksi_id" => $value,
                "rate" => $request->rating_score,
                "status" => "1",
                "komentar" => $request->comment
            ]);
        }

        $transaksi = Transaksi::where("order_id", "=", $request->comentar_number)->update(["status_done" => "1"]);
        if ($transaksi) {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect()->route('barang.view');
        } else {
            return redirect()->route("pages.list_transaksi");
        }
    }

    public function balas(Request $req)
    {
        $req->validate([
            "komentar" => "required|exists:komentars,id",
            "balasan" => "required"
        ]);

        $process = Balasan::create([
            "komentar_id" => $req->komentar,
            "balasan" => $req->balasan,
        ]);
        if ($process) {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect()->route('komentar.view');
        } else {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect()->route('komentar.view');
        }
    }

    public function change_status($komentar)
    {
        $komentars = Komentar::find($komentar);
        $check = $komentars->first();
        if ($check->status == 1) {
            $status_kode = 2;
        } else {
            $status_kode = 1;
        }
        $komentars->update([
            "status" => $status_kode
        ]);
        return response()->json(array('status' => "ok"));
    }
}
