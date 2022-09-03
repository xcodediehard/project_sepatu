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
        <div class="mt-2">

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th>No</th>
                    <th>Name</th>
                    <th>Barang</th>
                    <th>Komentar</th>
                    <th>Rate</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>No</th>
                    <th>Name</th>
                    <th>Barang</th>
                    <th>Komentar</th>
                    <th>Rate</th>
                    <th>Aksi</th>
                </tfoot>
                <tbody>
                    @foreach ($data['list'] as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->barang }}</td>
                        <td>{{ $item->komentar }}</td>
                        <td>{{ $item->rate }}</td>
                        <td>
                            @if ($item->status == 1)
                            <label class="switch">
                                <input type="checkbox" checked data-link="{{$item->id}}">
                                <span class="slider round"></span>
                            </label>
                            @else
                            <label class="switch">
                                <input type="checkbox" data-link="{{$item->id}}">
                                <span class="slider round"></span>
                            </label>
                            @endif

                            <div class="mt-2">
                                @include('components.modal',[
                                "modal"=>[
                                "color"=>"danger",
                                "id"=>"balas_komentar".$item->id,
                                "action"=>"Balas",
                                "url"=>route("komentar.balas"),
                                "content"=>"admin.contents.komentar.components.balas",
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

@push("scripts")
@include('admin.contents.komentar.components.scripts')
@endpush

@push("styles")
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endpush