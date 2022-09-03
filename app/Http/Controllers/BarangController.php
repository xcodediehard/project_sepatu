<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\Merek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    //

    private function insert_detail_barang($stok, $size, $id)
    {
        for ($i = 0; $i < count($stok); $i++) {
            $format = [
                'barang_id' => $id,
                'size' => $size[$i],
                'stok' => $stok[$i],
            ];
            DetailBarang::create($format);
        }

        return True;
    }

    public function update_detail_barang($stok, $size, $point, $id)
    {

        if (count($stok) == count($point)) {
            $i = 0;
            foreach ($point as $key => $value) {
                $format = [
                    'size' => $size[$i],
                    'stok' => $stok[$i],
                ];
                DetailBarang::find($value)->update($format);
                $i++;
            }
        }

        if (count($stok) > count($point)) {
            $start = (count($point) - 1);
            for ($i = $start; $i < count($size); $i++) {
                $format = [
                    'barang_id' => $id,
                    'size' => $size[$i],
                    'stok' => $stok[$i],
                ];
                DetailBarang::create($format);
            }
        }

        return True;
    }

    public function index()
    {
        $data = [
            "title" => "Barang",
            "list" => Barang::latest()->get(),
            "list_merek" => Merek::latest()->get()
        ];
        return view("admin.contents.barang.template", compact('data'));
    }

    public function store(Request $req)
    {
        $req->validate([
            "merek" => "required|exists:mereks,id",
            "barang" => "required|unique:barangs,barang_name",
            "harga" => "required",
            "gambar" => "mimes:png,jpg,jfif|image|required",
            "keterangan" => "required",
            'stok.*' => 'required',
            'size.*' => 'required',
        ]);

        $file = $req->file('gambar');
        $filename = $file->getClientOriginalName();

        $list_value = [
            "merek_id" => 1,
            "barang_name" => $req->barang,
            "barang_harga" => $req->harga,
            "barang_gambar" => $file->getClientOriginalName(),
            "barang_keterangan" => $req->keterangan
        ];

        $process = Barang::create($list_value);
        $detail = $this->insert_detail_barang($req->stok, $req->size, $process->id);
        if ($detail) {
            $path_upload = 'resources/barang/';
            $file->move($path_upload, $filename);
            session()->flash('success', 'Anda berhasil memasukan data');
            return redirect()->back();
        } else {
            session()->flash('error', 'Data gagal memasukan data');
            return redirect()->back();
        }
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            "merek" => "required|exists:mereks,id",
            "barang" => "required",
            "harga" => "required",
            "keterangan" => "required",
            "point.*" => "required|exists:detail_barangs,id",
            "stok.*" => "required",
            "size.*" => "required"
        ]);

        $barang = Barang::find($id);
        $file = $req->file('gambar');

        if ($file !== null) {
            $filename = $file->getClientOriginalName();
        } else {
            $filename = $barang->barang_gambar;
        }

        $list_values = [
            "merek_id" => $req->merek,
            "barang_name" => $req->barang,
            "barang_harga" => $req->harga,
            "barang_gambar" => $filename,
            "barang_keterangan" => $req->keterangan
        ];


        $process = $barang->update($list_values);
        if (!empty($req->del_list)) {
            foreach ($req->del_list as $key => $value) {
                DetailBarang::find($value)->delete();
            }
        }
        $update_detail = $this->update_detail_barang($req->stok, $req->size, $req->point, $barang->id);
        if ($update_detail && $process) {
            $path_delete = 'resources/barang/' . $filename;
            if (File::exists($path_delete)) {
                File::delete($path_delete);
                $path_upload = 'resources/barang/';
                $file->move($path_upload, $filename);
            }
            session()->flash('success', 'Anda berhasil ubah data');
            return redirect()->back();
        } else {
            session()->flash('error', 'Data gagal ubah data');
            return redirect()->back();
        }
    }

    public function destroy(Barang $barang)
    {
        $filename = $barang->barang_gambar;
        $process = $barang->delete();
        if ($process) {
            $path_delete = 'resources/barang/' . $filename;
            if (File::exists($path_delete)) {
                File::delete($path_delete);
            }
            session()->flash('success', 'Anda berhasil hapus data');
            return redirect()->back();
        } else {
            session()->flash('success', 'Anda gagal hapus data');
            return redirect()->back();
        }
    }
}


// $barang["barang"] = $request->barang;
// $barang["id_merek"] = $request->merek;
// $barang["harga"] = $request->harga;
// $barang["keterangan"] = $request->keterangan;
// if ($request->file('gambar') != null) {
//     $file = $request->file('gambar');
//     $filename = $file->getClientOriginalName();
//     $barang["gambar"] = $filename;
// }
// $post = $barang->save();

// if ($post) {
//     if ($request->file('gambar') != null) {
//         $path_delete = 'resources/image/barang/' . $filename;
//         if (File::exists($path_delete)) {
//             File::delete($path_delete);
//         }
//         $path_upload = 'resources/image/barang/';
//         $file->move($path_upload, $filename);
//     }
//     session()->flash('success', 'Data berhasil diedit');
//     return redirect()->route('barang.view');
// } else {
//     session()->flash('error', 'Data gagal diedit');
//     return redirect()->route('barang.view');
// }



// $file = $request->file('image');
// $filename = $file->getClientOriginalName();
// $format = [
//     "barang" => $request->barang,
//     "id_merek" => $request->merek,
//     "gambar" => $filename,
//     "harga" => $request->harga,
//     "keterangan" => $request->katerangan,
// ];
// $post = Barang::create($format);
// $detail = $this->insert_detail_barang($request->stok, $request->size, $post->id);
// if ($detail == True) {
//     $path_upload = 'resources/image/barang/';
//     $file->move($path_upload, $filename);
//     session()->flash('success', 'Data berhasil dimasukan');
//     return redirect()->route('barang.view');
// } else {
//     session()->flash('error', 'Data gagal dimasukan');
//     return redirect()->route('barang.view');
// }