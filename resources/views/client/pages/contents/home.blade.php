@extends('client.pages.template')
@section('pages_content')
<div class="container mt-4 text-dark">
    <h1>{{$data["title_cart"]}}</h1>
    <div class="row">
        @foreach ($data["list_cart"] as $item)
        <a class="btn btn-light mr-2 mt-2"
            href="{{ route('keranjang.index', ['name'=>str_replace(" ","+",$item["barang"]->barang_name)]) }}">
            <div class="card mr-2 mt-2" style="width: 18rem;">
                <img src="{{ asset('resources') }}/barang/{{$item["barang"]->barang_gambar}}" class="card-img-top"
                    alt="{{ asset('resources') }}/barang/{{$item["barang"]->barang_gambar}}">
                <div class="card-body">

                    <h5 class="card-title">{{$item["barang"]->barang_name}}</h5>
                    <p class="card-text">{{$item["barang"]->barang_keterangan}}</p>
                    <h5>Rp.{{number_format($item["barang"]->barang_harga)}}</h5>
                    <b>Rating / {{$item["rating"]}}</b> <br>
                    @for ($i = 0; $i < 5 ; $i++) @if ($item["rating"] <=$i) <i class="fas fa-star"></i>
                        @else
                        <i class="fas fa-star text-warning"></i>

                        @endif
                        @endfor
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection