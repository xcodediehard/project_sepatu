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
            {{-- @include('components.modal',[
            "modal"=>[
            "color"=>"primary",
            "id"=>"add_merek",
            "action"=>"Add",
            "url"=>route('merek.insert'),
            "content"=>"admin.contents.merek.components.add",
            "show_title"=>True
            ]]) --}}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>

                    <th>no</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>

                </thead>
                <tfoot>

                    <th>no</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                </tfoot>
                <tbody>
                    @foreach ($data["list"] as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->alamat }}</td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection