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
            "user_id" => 1,
            "merek_name" => $req->merek
        ];
        $process = Merek::create($list_value);
        if ($process) {
            return response()->json(["status" => "success insert"], 200);
        } else {
            return response()->json(["status" => "fail insert"], 401);
        }
    }

    public function update(Request $req, $merek)
    {
        $req->validate([
            "merek" => "required|unique:mereks,merek_name"
        ]);
        $list_value = [
            "user_id" => 1,
            "merek_name" => $req->merek
        ];

        $base = Merek::find($merek);

        $process = $base->update($list_value);
        if ($process) {
            return response()->json(["status" => "success update"], 200);
        } else {
            return response()->json(["status" => "fail update"], 401);
        }
    }


    public function destroy(Merek $merek)
    {
        $process = $merek->delete();
        if ($process) {
            return response()->json(["status" => "success delete"], 200);
        } else {
            return response()->json(["status" => "fail delete"], 401);
        }
    }
}
