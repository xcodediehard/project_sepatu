<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Embed\Midtrans\CreateSnapTokenService;
use App\Embed\Midtrans\StatusTransactionService;
use App\Models\DetailTransaksi;
use App\Models\Komentar;
use App\Models\Kota;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    //
    public function checkout(Request $req)
    {
        $req->validate([
            'jumlah' => "required",
            'size' => "required|exists:detail_barangs,id",
        ]);

        $detail_data = DB::select("SELECT b.barang_name,b.barang_harga,a.size,b.barang_gambar FROM detail_barangs a LEFT JOIN barangs b ON a.barang_id = b.id WHERE a.id =" . $req->size);
        $data_midtrans = [[
            "id" => rand(),
            "price" => $detail_data[0]->barang_harga,
            "quantity" => $req->jumlah,
            "name" => $detail_data[0]->barang_name . " Size " . $detail_data[0]->size
        ]];

        session()->forget("midtrans");
        session(["midtrans" => $data_midtrans]);

        $data_store = [[
            "detail_barang_id" => $req->size,
            "jumlah" => $req->jumlah,
            "biaya" => $detail_data[0]->barang_harga
        ]];

        session()->forget("store");
        session(["store" => $data_store]);

        $data_display = [[
            "detail_barang_id" => $req->size,
            "jumlah" => $req->jumlah,
            "biaya" => $detail_data[0]->barang_harga,
            "gambar" => $detail_data[0]->barang_gambar,
            "nama" => $detail_data[0]->barang_name,
            "size" => $detail_data[0]->size,
        ]];

        session()->forget("display");
        session(["display" => $data_display]);

        return redirect()->route("transaksi.payment");
    }

    public function payment()
    {
        $data = [
            "title" => "Payment",
            "list_cart" => session("display"),
            "provinsi" => Provinsi::all(),
            "kurir" => (object)["jne" => "JNE", "pos" => "POS", "tiki" => "TIKI"]
        ];
        return view("client.cart.contents.checkout", compact("data"));
    }

    public function get_account(Request $req)
    {

        $validator = Validator::make($req->all(), [
            "cost" => "required",
            "name" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => $validator->errors()], 401);
        }

        $list = session("midtrans");

        array_push($list, [
            "id" => rand(),
            "price" => $req->cost,
            "name" => $req->name,
            "quantity" => 1,
        ]);

        $total = 0;
        foreach ($list as $value) {
            $total += $value["price"] * $value["quantity"];
        }

        $order = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $total,
            ],
            "item_details" => $list,
            'customer_details' => [
                'first_name' => auth()->guard("client")->user()->nama,
                'email' => auth()->guard("client")->user()->email,
                'phone' => auth()->guard("client")->user()->telfon,
            ]
        ];

        $code = new CreateSnapTokenService($order);
        return response()->json(["status" => "sucess", "order" => $code->getSnapToken()], 200);
    }

    public function transaksi(Request $req)
    {
        $req->validate([
            "detail_pemesanan" => "required",
            "nama" => "required",
            "telfon" => "required",
            "alamat" => "required",
            "provinsi" => "required|exists:provinsis,province_id",
            "kota" => "required|exists:kotas,city_id",
            "kurir" => "required",
            "paket_destination" => "required",
            "paket" => "required"
        ]);
        $provinsi = Provinsi::where("province_id", "=", $req->provinsi)->first();
        $kota = Kota::where("city_id", "=", $req->kota)->first();
        $address = $req->alamat . "," . $provinsi->name . "," . $kota->name . " (" . $req->kurir . ", Paket " . $req->paket_destination . ") | " . $req->nama . " (" . $req->telfon . ")";
        $object_status = new StatusTransactionService($req->detail_pemesanan);
        $status = $object_status->getstatus();
        if ($status->transaction_status === 'pending') {
            $code_status = '2';
        } elseif ($status->transaction_status === 'settlement') {
            $code_status = '1';
        } elseif ($status->transaction_status === 'expire') {
            $code_status = '3';
        } else {
            $code_status = '4';
        }
        $list_transaksi = [
            "pelanggan_id" => auth()->guard("client")->user()->id,
            "order_id" => $req->detail_pemesanan,
            "alamat" => strtoupper($address),
            "biaya" => $req->paket,
            "status" => $code_status,
        ];
        $transaksi = Transaksi::create($list_transaksi);

        if ($transaksi) {
            foreach (session("store") as $value) {
                $list_detail_transkasi = [
                    "order_id" => $req->detail_pemesanan,
                    "detail_barang_id" => $value["detail_barang_id"],
                    "jumlah" => $value["jumlah"],
                    "biaya" => ($value["jumlah"] * $value["biaya"])
                ];
                $detail_process = DetailTransaksi::create($list_detail_transkasi);
            }

            return redirect()->route("pages.home");
        }
    }

    public function status_transaksi()
    {
        $transaksi_list = Transaksi::where("pelanggan_id", "=", auth()->guard("client")->user()->id)->get();
        $detail_transaksi = collect($transaksi_list)->map(function ($response) {
            $detail_transaksi = DB::select("SELECT * FROM detail_transaksis a LEFT JOIN detail_barangs b ON a.detail_barang_id = b.id LEFT JOIN barangs c ON b.barang_id = c.id WHERE a.order_id = " . $response->order_id);
            $object_status = new StatusTransactionService($response->order_id);
            $status = $object_status->getstatus();
            if ($status->transaction_status === 'pending') {
                $colors = 'warning';
                $code_status = '2';
            } elseif ($status->transaction_status === 'settlement') {
                $colors = 'primary';
                $code_status = '1';
            } elseif ($status->transaction_status === 'expire') {
                $colors = 'danger';
                $code_status = '3';
            } else {
                $colors = 'dark';
                $code_status = '4';
            }
            Transaksi::where("order_id", "=", $response->order_id)->update(["status" => $code_status]);
            $data = [
                "status" => [
                    "code" => $response->order_id,
                    "alamat" => $response->alamat,
                    "biaya_total" => $status->gross_amount,
                    "va_numbers" => $status->va_numbers[0]->va_number,
                    "bank" => $status->va_numbers[0]->bank,
                    "transaction_status" => $status->transaction_status,
                    "status" => $response->status,
                    "color" => $colors,
                    "validation" => $response->status_done,
                ],
                "detail" => $detail_transaksi,
            ];
            return $data;
        });

        $data = [
            "title" => "Transaksi",
            "list_data" => $detail_transaksi
        ];
        return view("client.cart.contents.list_transaksi", compact("data"));
    }

    public function send_comment(Request $request)
    {
        // dd($request->all());
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
            return redirect()->route("pages.home");
        } else {
            return redirect()->route("pages.home");
        }
    }
}
