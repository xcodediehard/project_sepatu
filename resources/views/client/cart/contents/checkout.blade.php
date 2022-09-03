@extends('client.cart.template')
@section('cart_content')
<div class="container text-dark mt-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Detail Pemesanan</h4>
                </div>
                <div class="card-body">
                    @php
                    $total =0
                    @endphp
                    @foreach ($data["list_cart"] as $cart)
                    @php
                    $total +=$cart["jumlah"]
                    @endphp
                    <div class="card mb-2" style="max-width: 580px;">
                        <div class="row no-gutters">
                            <div class="col-md-5 my-auto">
                                <img src="{{ asset('resources/barang/'.$cart["gambar"]) }}"
                                    alt="{{ asset('resources/barang/'.$cart["gambar"]) }}" class="w-100">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">{{$cart["nama"]}} Size ({{$cart["size"]}})</h5>
                                    <b>Jumlah :</b>
                                    <p>{{$cart["jumlah"]}} x Rp.{{number_format($cart["biaya"])}}</p>
                                    <hr>
                                    <h4>Total : Rp. {{number_format($cart["biaya"] * $cart["jumlah"])}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- <div class="card-footer">
                    <div class="form-group">
                        <label for="">Promo Code</label>
                        <input type="text" required
                            class="form-control form-control-user @include('components.invalid',['error'=>'promocode'])"
                            name="promocode" id="exampleInputpromocode" placeholder="Masukan Promo Code ">
                        @include('components.alert',['error'=>'promocode'])
                    </div>
                    <button class="btn btn-primary btn-code">Redeem</button>
                </div> --}}
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Formulir Penerima</h5>
                </div>
                <form action="{{ route('transaksi.transaksi') }}" method="post">
                    @csrf
                    <input type="hidden" name="detail_pemesanan">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Penerima</label>
                            <input type="text" required
                                class="form-control form-control-user @include('components.invalid',['error'=>'nama'])"
                                name="nama" id="exampleInputnama" placeholder="nama" value="" required>
                            @include('components.alert',['error'=>'nama'])
                        </div>
                        <div class="form-group">
                            <label for="">Telfon Penerima</label>
                            <input type="text" required
                                class="form-control form-control-user @include('components.invalid',['error'=>'telfon'])"
                                name="telfon" id="exampleInputtelfon" placeholder="telfon " required maxlength="15">
                            @include('components.alert',['error'=>'telfon'])
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat" required id="exampleFormControlTextarea1"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Provinsi</label>
                            <select class="form-control @include('components.invalid',['error'=>'provinsi'])" required
                                name="provinsi" id="exampleFormControlSelect1">
                                <option value="empty">Pilih Provinsi</option>
                                @foreach ($data["provinsi"] as $provinsi)
                                <option value="{{$provinsi->province_id}}">{{$provinsi->name}}</option>
                                @endforeach
                            </select>
                            @include('components.alert',['error'=>'provinsi'])
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kota</label>
                            <select class="form-control @include('components.invalid',['error'=>'kota'])" name="kota"
                                required id="exampleFormControlSelect1">
                                <option value="empty">Pilih Provinsi Terlebih Dahulu</option>
                            </select>
                            @include('components.alert',['error'=>'kota'])
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kurir</label>
                            <select class="form-control @include('components.invalid',['error'=>'kurir'])" name="kurir"
                                required id="exampleFormControlSelect1">
                                <option value="empty">Pilih Kurir</option>
                                @foreach ($data["kurir"] as $kurir_key=>$kurir_val)
                                <option value="{{$kurir_key}}">{{$kurir_val}}</option>
                                @endforeach
                            </select>
                            @include('components.alert',['error'=>'kurir'])
                        </div>
                        <input type="hidden" name="paket_destination">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Paket</label>
                            <select class="form-control @include('components.invalid',['error'=>'paket'])" name="paket"
                                required id="exampleFormControlSelect1">
                                <option value="empty">Pilih Kota Terlebih Dahulu</option>
                            </select>
                            @include('components.alert',['error'=>'paket'])
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class="btn btn-primary my-3 btn-block btn-lg" id="pay-button">LAKUKAN PAYMENT</button>
</div>
@push("scripts")
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
    $("select[name='provinsi']").change(function (e) { 
        e.preventDefault();
        let value = $(this).val();
        $("select[name='kota']").html("");
        $.ajax({
            type: "GET",
            url: "/api/getcity/"+value,
            dataType: "JSON",
            success: function (response) {
                $("select[name='kota']").append("<option>Pilih Kota</option>");
                $.each(response, function (index, value) { 
                    $("select[name='kota']").append(`<option value="${index}">${value}</option>`);
                });
            }
        });
    });

    $("select[name='kurir']").change(function (e) { 
        e.preventDefault();
        check_payment()
    });  
    
    $("select[name='kota']").change(function (e) { 
        e.preventDefault();
        check_payment()
    });


    function check_payment() {
        let kurir =$("select[name='kurir']").find("option:selected").val();
        let provinsi =$("select[name='provinsi']").find("option:selected").val();
        let kota =$("select[name='kota']").find("option:selected").val();
        if(kurir !== 'empty' && provinsi !== 'empty' && kota !== 'empty'){
            let weight = {{$total * 1000}}

            console.log( kota+weight+kurir)
            $("select[name='paket']").html("")
            $.ajax({
                type: "POST",
                url: "/api/cost/",
                data: {
                    "destination" : kota,
                    "weight" : weight,
                    "courier":kurir
                },
                dataType: "JSON",
                success: function (response) {
                    $.each(response[0].costs, function (index, value) { 
                            let cost_value =value.cost[0].value;
                            let day = value.cost[0].etd
                            let the_day = day.includes("HARI")==true?day:day+" HARI";
                            let description =value.description;
                            let service = value.service
                            let cost_current = new Intl.NumberFormat("id-ID", {style: "currency",currency: "IDR"}).format(cost_value)
                            $("select[name='paket']").append(` <option value="${cost_value}">${service} ${cost_current} / estimasi ${the_day} </option>`);
                            $("input[name='paket_destination']").val(description);
                        });
                }
            });
        }
    }

    let snap_code = ""
    $("select[name='paket']").change(function (e) { 
        e.preventDefault();
        let code = $(this).find("option:selected").val();
        let name = $(this).find("option:selected").html();
        $.ajax({
            type: "POST",
            url: "{{route("api.get_account")}}",
            data :{
                "_token":"{{csrf_token()}}",
                "cost":code,
                "name":name
            },
            dataType: "JSON",
            success: function (response) {
                snap_code = String(response.order);
                // if (response.status === "success") {
                //     snap_code = response.order
                // }
            }
        });
    });
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        // console.log(snap_code)
        snap.pay(snap_code, {
            // Optional
            onSuccess: function(result) {
                // console.log("success")
                // console.log(result.order_id)
                $("input[name='detail_pemesanan']").attr("value",result.order_id);
                $("form").submit();
                // console.log(result)
            },
            // Optional
            onPending: function(result) {
                // console.log("pendding")
                // console.log(result.order_id)
                $("input[name='detail_pemesanan']").attr("value",result.order_id);
                $("form").submit();
            },
            // Optional
            onError: function(result) {
                // console.log("error")
                // console.log(result.order_id)
                $("input[name='detail_pemesanan']").attr("value",result.order_id);
                $("form").submit();
            }
        });
    });
</script>
@endpush
@endsection