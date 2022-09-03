@extends('client.cart.template')
@section('cart_content')
<div class="container mt-4 text-dark">
    <div class="card">
        <div class="card-header">
            <h4>History Transaksi</h4>
        </div>
        <div class="card-body">
            @foreach ($data["list_data"] as $item)
            <div class="card mt-2">
                <div class="card-header">
                    <h4>{{strtoupper($item["status"]["bank"])}} / {{$item["status"]["va_numbers"]}}</h4>
                </div>
                <div class="card-body">
                    <b>Status : </b>
                    <h4 class="text-{{$item["status"]["color"]}} font-weight-bold">
                        {{strtoupper($item["status"]["transaction_status"])}}
                    </h4>
                    <b>Total Pembayaran : </b>
                    <h4 class="font-weight-bold">
                        Rp. {{strtoupper(number_format($item["status"]["biaya_total"]))}}
                    </h4>
                    <button class="btn btn-primary mb-2" type="button" data-toggle="collapse"
                        data-target="#detail{{$item["status"]["va_numbers"]}}" aria-expanded="false"
                        aria-controls="detail{{$item["status"]["va_numbers"]}}">
                        Detail
                    </button>
                    {{-- KOMENTAR --}}
                    @if ($item["status"]["validation"] == 0)
                    <button class="btn btn-primary mb-2 validation_button" type="button" data-toggle="collapse"
                        data-target="#validation_button{{$item["status"]["va_numbers"]}}" aria-expanded="false"
                        aria-controls="validation_button{{$item["status"]["va_numbers"]}}">
                        Komentar
                    </button>
                    <div class="collapse" id="validation_button{{$item["status"]["va_numbers"]}}">
                        <div class="card card-body">
                            <div class="card">
                                <div class="card-header">
                                    <b>Jika anda sudah menerima barang silahkan validasi dan berikan komentar
                                        serta
                                        rating, Terima kasih.</b>
                                </div>
                                <form action="{{ route('transaksi.send_comment') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="comentar_number" value="{{$item["status"]["code"]}}">
                                    @foreach ($item["detail"] as $details)
                                    <input type="hidden" name="barang[]" value="{{$details->payment_id}}">
                                    @endforeach
                                    <div class="card-body">
                                        <h5>Rating dan Komentar</h5>
                                        <div class="star-score-{{$item["status"]["va_numbers"]}}">
                                            <i class="fas fa-star" data-star="1"></i>
                                            <i class="fas fa-star" data-star="2"></i>
                                            <i class="fas fa-star" data-star="3"></i>
                                            <i class="fas fa-star" data-star="4"></i>
                                            <i class="fas fa-star" data-star="5"></i>
                                            <input type="hidden" name="rating_score" class="rating-value" value="3">
                                            <hr>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Pesan</label>
                                                <textarea class="form-control" name="comment"
                                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Kirim Validasi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="collapse" id="detail{{$item["status"]["va_numbers"]}}">
                        <div class="card card-body">
                            <ul class="list-group">
                                <li class="list-group-item active" aria-current="true">An active item</li>
                                @foreach ($item["detail"] as $detail)
                                <li class="list-group-item">
                                    <b>Nama :</b>
                                    <p>{{$detail->barang_name}}</p>
                                    <b>Jumlah :</b>
                                    <p>{{$detail->jumlah}}</p>
                                    <b>Biaya :</b>
                                    <p>Rp.{{number_format($detail->biaya)}}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@push("scripts")
<script>
    $(document).ready(function() {
    $(".validation_button").on("click", function () {
        get_data = $(this).data("target");
        current_validation = get_data.split("validation_button")[1]
        var $star_rating = $(`.star-score-${current_validation} .fas`);

            var SetRatingStar = function() {
            return $star_rating.each(function() {
                if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('star'))) {
                return $(this).attr("class","fas fa-star text-warning");
                } else {
                return $(this).attr("class","fas fa-star");
                }
            });
        };

        $star_rating.on('click', function() {
            $star_rating.siblings('input.rating-value').val($(this).data('star'));
            return SetRatingStar();
        });
            SetRatingStar();
    });
    

});
</script>
@endpush
@endsection