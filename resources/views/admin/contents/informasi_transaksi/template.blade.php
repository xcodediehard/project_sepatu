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
            <table border="0" cellspacing="5" cellpadding="5">
                <tbody>
                    <tr>
                        <td>Minimum date:</td>
                        <td><input type="text" id="min" name="min"></td>
                    </tr>
                    <tr>
                        <td>Maximum date:</td>
                        <td><input type="text" id="max" name="max"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered" id="datatabledate" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status Transaksi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Status Transaksi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Detail</th>

                </tfoot>
                <tbody>
                    @foreach ($data['list'] as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            <div class="btn btn-{{$item->color}}" role="alert">
                                {{$item->transaction_status}}
                            </div>
                        </td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->alamat}} ({{$item->telpon}})</td>
                        <td>Rp.{{number_format($item->gross_amount)}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <div class="mt-2">
                                @include('components.modal',[
                                "modal"=>[
                                "color"=>"primary",
                                "id"=>"delete_komentar".$item->id,
                                "action"=>"Detail",
                                "url"=>"",
                                "content"=>"admin.contents.informasi_transaksi.components.detail_transaksi",
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

@push('styple')

@endpush
@push("scripts")

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('templates') }}/js/demo/datatables-date.js"></script>
@endpush
@endsection