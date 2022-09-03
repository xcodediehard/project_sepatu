@extends('client.cart.template')
@section('cart_content')

<form action="{{ route('transaksi.transaksi_list') }}" method="post">
    @csrf
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="cotainer p-2">
                        <div class="col">
                            <div class="row">
                                @foreach ($data['list_cart'] as $cart_item)
                                <div class="card mb-3 border border-primary" style="max-width: 70rem;">
                                    @if ($cart_item->available_stok == 'full')
                                    <h4 class="position-absolute ml-1 mt-1  font-weight-bolder text-danger">Not
                                        Available
                                        Stock
                                    </h4>
                                    @endif
                                    <div class="row no-gutters">
                                        <div class="col-md-2 d-flex align-items-center justify-content-center my-4">
                                            @if ($cart_item->available_stok == 'avail')
                                            <div class="card-header">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input checkbox_data"
                                                        data-value="{{ $cart_item->pembayaran }}"
                                                        data-count="{{ $cart_item->jumlah }}" type="checkbox"
                                                        id="inlineCheckbox1" name="cart[]"
                                                        value="{{ $cart_item->keranjang }}"
                                                        style="transform: scale(4);padding: 10px;">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-2 d-flex align-items-center justify-content-center my-4"
                                            style="@if ($cart_item->available_stok == 'full')
                                        filter: blur(4px);
                                    @endif">
                                            <img src="{{ asset('resources/barang/'.$cart_item->gambar) }}"
                                                alt="{{ asset('resources/barang/'.$cart_item->gambar) }}" class="w-100">
                                        </div>
                                        <divs class="col-md-6">
                                            <div class="card-body text-dark" style="@if ($cart_item->available_stok == 'full')
                                            filter: blur(4px);
                                        @endif">
                                                <h5 class="card-title"><b>{{ $cart_item->barang }}</b></h5>
                                                <p class="card-text">
                                                    <b>Size &emsp;&emsp;: </b> {{ $cart_item->detail_size}} <br>
                                                    <b>Harga &emsp;: </b> Rp.{{ number_format($cart_item->harga) }} <br>
                                                    <b>Jumlah&emsp;: </b> {{ $cart_item->jumlah}} pasang<br>
                                                    <hr>
                                                <div class="text-primary">
                                                    <b>Total:</b>
                                                    <h5> <b>Rp.{{ number_format($cart_item->pembayaran) }}</b></h5>
                                                </div>
                                                </p>
                                            </div>
                                        </divs>
                                        <div class="col-md-2 d-flex justify-content-end ">
                                            <div class="card-footer bg-white">
                                                <a href="{{ route('pages.delete_keranjang', ["keranjang"=>$cart_item->keranjang]) }}"
                                                    class="btn btn-outline-danger"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg bg-danger text-white">
                        <h6>Lakukan Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Payment <i
                                class="fas fa-money-bill-wave"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('name')
<script>
    $("button[type='submit']").on(events, function () {
            var checked = $("input[name='cart[]']:checked").length > 0;
    if (checked){
        $("form").submit();
    }
        });
</script>
@endpush