@extends('admin.template')
@section('content')
<h1>Selamat Datang, {{auth()->guard("admin")->user()->name}}</h1>
@endsection