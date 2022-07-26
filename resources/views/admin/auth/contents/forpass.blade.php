@extends('admin.auth.auth_template')

@section('auth_content')
<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block ">
                            <img src="{{ asset('illustration') }}/forgot_password.png"
                                alt="{{ asset('illustration') }}/forgot_password.png" class="w-100 ">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">Gunakan untuk mengganti password lama dengan password baru</p>
                                </div>
                                <form class="user" method="post" action="{{ route('auth.forpass_proses') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" required
                                            class="form-control form-control-user @include('components.invalid',['error'=>'email'])"
                                            name="email" id="exampleInputEmail" placeholder="Email ">
                                        @include('components.alert',['error'=>'email'])
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('user.register') }}">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('user.login') }}">Already have an account?
                                        Login!</a>
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