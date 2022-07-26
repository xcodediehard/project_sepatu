@extends('client.auth.auth_template')

@section('auth_content')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{ asset('illustration') }}/login.png" alt="{{ asset('illustration') }}/login.png"
                                class="w-100">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    @include('components.notify')
                                </div>
                                <form class="user" action="{{ route('user.login_proses') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" required
                                            class="form-control form-control-user @include('components.invalid',['error'=>'email'])"
                                            name="email" id="exampleInputEmail" placeholder="Email ">
                                        @include('components.alert',['error'=>'email'])
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required minlength="8"
                                            class="form-control form-control-user @include('components.invalid',['error'=>'password'])"
                                            name="password" id="password" placeholder="Password">
                                        @include('components.alert',['error'=>'password'])
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('user.forpass') }}">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('user.register') }}">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('pages.home') }}">Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


@endsection