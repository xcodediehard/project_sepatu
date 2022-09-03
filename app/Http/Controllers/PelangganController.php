<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    //
    public function index()
    {
        $data = [
            "title" => "Pelanggan",
            "list" => Pelanggan::latest()->get()
        ];
        return view("admin.contents.informasi_pelanggan.template", compact('data'));
    }
}
