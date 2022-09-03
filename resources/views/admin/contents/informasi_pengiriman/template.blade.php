@extends('admin.template')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">{{ $data["title"] }}</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="mt-2">
        @include('components.notify')
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables {{ $data["title"] }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sepatu</th>
                        <th>Ukuran (CM)</th>
                        <th>Alamat</th>
                        <th>Nomer Resi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Sepatu</th>
                        <th>Ukuran (CM)</th>
                        <th>Alamat</th>
                        <th>Nomer Resi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>

                </tfoot>
                <tbody>
                    @foreach ($data['list'] as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->barang_name}}</td>
                        <td>{{$item->size}} CM</td>
                        <td>{{$item->alamat}}</td>
                        <td>{{$item->resi}}</td>
                        <td>
                            @if ($item->gambar != "img")
                            <img src="{{ asset('resources/resi/'.$item->gambar) }}"
                                alt="{{ asset('resources/resi/'.$item->gambar) }}" class="w-100">
                            @endif
                        </td>
                        <td>
                            <div class="mt-2">
                                @include('components.modal',[
                                "modal"=>[
                                "color"=>"primary",
                                "id"=>"validasi_pengiriman".$item->id,
                                "action"=>"Validasi Pengiriman",
                                "url"=>route("validation_pengiriman.transaksi"),
                                "content"=>"admin.contents.informasi_pengiriman.components.detail_transaksi",
                                "show_title"=>False
                                ]])
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection