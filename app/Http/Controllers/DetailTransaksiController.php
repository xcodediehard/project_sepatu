<?php

namespace App\Http\Controllers;

use App\Embed\Midtrans\StatusTransactionService;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    //
    public function informasi_transaksi()
    {
        $transaksi = Transaksi::latest()->get();
        $detail_transaksi = collect($transaksi)->map(function ($response) {
            $detail_item = DB::select('SELECT c.barang_name,a.jumlah FROM detail_transaksis a LEFT JOIN detail_barangs b ON a.detail_barang_id=b.id LEFT JOIN barangs c ON b.barang_id = c.id WHERE a.order_id = ' . $response->order_id);
            $statusTransaksi = new StatusTransactionService($response->order_id);
            $liststatus = (object)$statusTransaksi->getstatus();

            $client = Pelanggan::find($response->pelanggan_id)->first();

            if ($liststatus->transaction_status === 'pending') {
                $color = "warning";
            } elseif ($liststatus->transaction_status === 'expire') {
                $color = "danger";
            } else {
                $color = "primary";
            }
            $result = [
                "id" => $response->id,
                "id_pelanggan" => $response->id_pelanggan,
                "order_id" => $response->order_id,
                "keterangan" => $response->keterangan,
                "nama" => $client["nama"],
                "email" => $client["email"],
                "telpon" => $client["telfon"],
                "alamat" => $response->alamat,
                "biaya" => $response->biaya,
                "detail_itema_numbers" => $liststatus->va_numbers,
                "gross_amount" => $liststatus->gross_amount,
                "payment_type" => $liststatus->payment_type,
                "transaction_status" => $liststatus->transaction_status,
                "color" => $color,
                "detail_transaksi" => $detail_item
            ];
            return (object)$result;
        });
        $data = [
            "title" => "Informasi Transaksi",
            "list" => $detail_transaksi
        ];
        return view("admin.contents.informasi_transaksi.template", compact('data'));
    }
    public function informasi_pengiriman()
    {
        $detail_transaksi = DB::select("SELECT a.id, b.alamat,a.jumlah,a.biaya,a.resi,a.gambar,b.status, c.size, d.barang_name FROM `detail_transaksis` a LEFT JOIN transaksis b ON a.order_id=b.order_id LEFT JOIN detail_barangs c  ON a.detail_barang_id = c.id LEFT JOIN barangs d  ON c.barang_id=d.id WHERE b.status =1");
        $data = [
            "title" => "Informasi Pengiriman",
            "list" => $detail_transaksi
        ];
        return view("admin.contents.informasi_pengiriman.template", compact('data'));
    }


    public function validation_pengiriman(Request $req)
    {
        $req->validate([
            "code" => "required|exists:detail_transaksis,id",
            "resi" => "required",
            "image" => "required|image|mimes:png,jpg,jfif,jpeg"
        ]);

        $file = $req->file('image');
        $filename = $file->getClientOriginalName();
        $process = DetailTransaksi::find($req->code)->update([
            "resi" => $req->resi,
            "gambar" => $filename,
            "status" => "1"
        ]);

        if ($process) {
            $path_upload = 'resources/resi/';
            $file->move($path_upload, $filename);
            session()->flash('success', 'Anda berhasil memasukan data');
            return redirect()->back();
        } else {
            session()->flash('error', 'Data gagal memasukan data');
            return redirect()->back();
        }
    }
}
