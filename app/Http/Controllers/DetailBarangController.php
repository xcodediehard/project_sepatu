<?php

namespace App\Http\Controllers;

use App\Models\DetailBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailBarangController extends Controller
{
    //

    public function index()
    {
        $data = [
            "title" => "Detail Barang",
            "list_data" => DetailBarang::latest()->get()
        ];
        return response()->json($data, 200);
    }

    public function store(Request $req)
    {
        $validate = Validator::make($req->all(), [
            "code" => "required|exists:barangs,id",
            "stok" => "required",
            "size" => "required"
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 401);
        }

        $list_value = [
            "barang_id" => $req->code,
            "stok" => $req->stok,
            "size" => $req->size,
        ];

        $process = DetailBarang::create($list_value);
        if ($process) {
            return response()->json(["status" => "success insert"], 200);
        } else {
            return response()->json(["error" => "fail insert"], 401);
        }
    }

    public function update(Request $req, $detail_barang)
    {

        $validate = Validator::make($req->all(), [
            "code" => "required|exists:barangs,id",
            "stok" => "required",
            "size" => "required"
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 401);
        }

        $base = DetailBarang::find($detail_barang);
        $list_value = [
            "barang_id" => $req->code,
            "stok" => $req->stok,
            "size" => $req->size,
        ];
        $process = $base->update($list_value);
        if ($process) {
            return response()->json(["status" => "success update"], 200);
        } else {
            return response()->json(["status" => "fail update"], 401);
        }
    }

    public function destroy(DetailBarang $detail_barang)
    {
        $process = $detail_barang->delete();
        if ($process) {
            return response()->json(["status" => "success delete"], 200);
        } else {
            return response()->json(["status" => "fail delete"], 401);
        }
    }
}
