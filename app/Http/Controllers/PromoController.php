<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    //
    public function index()
    {
        $data = [
            "title " => "Promo",
            "list_data" => Promo::latest()->get()
        ];
        return response()->json($data, 200);
    }

    public function store(Request $req)
    {
        $validate = Validator::make($req->all(), [
            "promo" => "required",
            "promocode" => "required|unique:promos,promo_code",
            "harga" => "required",
            "code" => "required|exists:barangs,id"
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 401);
        }

        $list_value = [
            "barang_id" => $req->code,
            "promo_nama" => $req->promo,
            "promo_harga" => $req->harga,
            "promo_code" => $req->promocode,
        ];

        $process = Promo::create($list_value);
        if ($process) {
            return response()->json(["status" => "success insert"], 200);
        } else {
            return response()->json(["error" => "fail insert"], 401);
        }
    }

    public function update(Request $req, $promo)
    {
        $validate = Validator::make($req->all(), [
            "promo" => "required",
            "promocode" => "required|unique:promos,promo_code",
            "harga" => "required",
            "code" => "required|exists:barangs,id"
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 401);
        }

        $base = Promo::find($promo);
        $list_value = [
            "barang_id" => $req->code,
            "promo_nama" => $req->promo,
            "promo_harga" => $req->harga,
            "promo_code" => $req->promocode,
        ];

        $process = $base->update($list_value);
        if ($process) {
            return response()->json(["status" => "success update"], 200);
        } else {
            return response()->json(["status" => "fail update"], 401);
        }
    }

    public function destroy(Promo $promo)
    {
        $process = $promo->delete();
        if ($process) {
            return response()->json(["status" => "success delete"], 200);
        } else {
            return response()->json(["status" => "fail delete"], 401);
        }
    }
}
