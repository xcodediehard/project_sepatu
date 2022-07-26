<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationController extends Controller
{

    public function getCities($id)
    {
        $city = Kota::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }


    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => 135, // ID kota/kabupaten asal
            'destination'   => $request->destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();


        return response()->json($cost);
    }
}
