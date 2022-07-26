@extends('client.pages.template')
@section('pages_content')
<div class="container mt-4 text-dark">
    <h1>{{$data["title_cart"]}}</h1>
    <div class="row">
        @foreach ($data["list_cart"] as $item)
        <a class="btn btn-light"
            href="{{ route('keranjang.index', ['name'=>str_replace(" ","+",$item->barang_name)]) }}">
            <div class="card mr-2 mt-2" style="width: 18rem;">
                <img src="{{ asset('resources') }}/barang/{{$item->barang_gambar}}" class="card-img-top"
                    alt="{{ asset('resources') }}/barang/{{$item->barang_gambar}}">
                <div class="card-body">
                    <h5 class="card-title">{{$item->barang_name}}</h5>
                    <p class="card-text">{{$item->barang_keterangan}}</p>
                    <h5>Rp.{{number_format($item->barang_harga)}}</h5>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection