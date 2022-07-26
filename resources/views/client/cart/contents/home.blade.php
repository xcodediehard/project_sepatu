@extends('client.cart.template')
@section('cart_content')
<div class="container mt-4 text-dark">
    <div class="row">
        <div class="col">
            <div class="card">
                <img src="{{ asset('resources/barang/'.$data["list_cart"]->barang_gambar) }}"
                    alt="{{ asset('resources/barang/'.$data["list_cart"]->barang_gambar) }}" class="w-100 rounded">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card shadow-lg p-3">
                <div class="card-header bg bg-danger text-white">
                    <h4>Detail Produk</h4>
                </div>
                <div class="cart-body container">
                    <b>Produk :</b>
                    <h5>{{$data["list_cart"]->barang_name}}</h5>
                    <b>Keterangan : </b>
                    <h6>{{$data["list_cart"]->barang_keterangan}}</h6>
                    <b>Harga</b>
                    <h4>Rp.{{number_format($data["list_cart"]->barang_harga)}}</h4>
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pemesanan</h4>
                        </div>
                        <form action="" method="post">
                            @csrf
                            <div class="card-body">
                                <b>Pilih Size :</b>
                                @foreach ($data["list_cart"]->detail_barang as $item_detail)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios1"
                                        value="{{$item_detail->id}}">
                                    <label class="form-check-label" for="exampleRadios1">
                                        Size {{$item_detail->size}} ({{$item_detail->stok}})
                                    </label>
                                </div>
                                @endforeach
                                <hr>
                                <b>Masukan Jumlah Pemesanan :</b>
                                <div class="form-group">
                                    <input type="number" class="form-control" id="exampleInputEmail1" name="jumlah"
                                        aria-describedby="emailHelp" placeholder="Jumlah Pesanan" min="1" value="1"
                                        max="{{$item_detail->stok}}">
                                </div>
                            </div>
                        </form>
                        <div class="card-footer">
                            @if (!empty(auth()->guard("client")->user()))
                            <button class="btn btn-outline-danger btn-block btn-submit"
                                data-link="{{ route('transaksi.checkout') }}">Checkout</button>
                            <button class="btn btn-danger btn-block btn-submit">Keranjang</button>
                            @else
                            <a class="btn btn-outline-danger btn-block" href="{{ route('user.login') }}">Checkout</a>
                            <a class="btn btn-danger btn-block" href="{{ route('user.login') }}">Keranjang</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <div class="card">
            <div class="card-header border border-danger">
                <h4>Komentar</h4>
            </div>
            <div class="card-body border border-danger">

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(".btn-submit").on("click", function () {
        let link = $(this).data("link");
        $("form").attr("action", link);
        $("form").submit();
    });
</script>
@endpush
@endsection