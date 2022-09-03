<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{

    public function index()
    {
        $data = [
            "title" => "Merek",
            "list" => Merek::latest()->get()
        ];
        return view("admin.contents.merek.template", compact('data'));
    }

    public function store(Request $req)
    {
        $req->validate([
            "merek" => "required|unique:mereks,merek_name"
        ]);
        $list_value = [
            "user_id" => auth()->guard("admin")->user()->id,
            "merek_name" => $req->merek
        ];
        $process = Merek::create($list_value);
        if ($process) {
            session()->flash('success', 'Data berhasil dimasukan');
            return redirect()->route('merek.view');
        } else {
            session()->flash('error', 'Data gagal dimasukan');
            return redirect()->route('merek.view');
        }
    }

    public function update(Request $req, $merek)
    {
        $req->validate([
            "merek" => "required|unique:mereks,merek_name"
        ]);
        $list_value = [
            "user_id" => auth()->guard("admin")->user()->id,
            "merek_name" => $req->merek
        ];

        $base = Merek::find($merek);

        $process = $base->update($list_value);
        if ($process) {
            session()->flash('success', 'Data berhasil diedit');
            return redirect()->route('merek.view');
        } else {
            session()->flash('error', 'Data gagal diedit');
            return redirect()->route('merek.view');
        }
    }


    public function destroy(Merek $merek)
    {
        $process = $merek->delete();
        if ($process) {
            session()->flash('success', 'Data berhasil dihapus');
            return redirect()->route('merek.view');
        } else {
            session()->flash('error', 'Data gagal dihapus');
            return redirect()->route('merek.view');
        }
    }
}
