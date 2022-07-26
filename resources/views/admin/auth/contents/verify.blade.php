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
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{ asset('illustration') }}/verify.png"
                                alt="{{ asset('illustration') }}/verify.png" class="w-100">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    @include('components.notify')
                                </div>
                                <form class="user" method="post" action="{{ route('auth.verify_proses') }}">
                                    @csrf
                                    <input type="hidden" name="code" value={{$data["code"]}}>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" required minlength="8"
                                                class="form-control form-control-user @include('components.invalid',['error'=>'password'])"
                                                name="password" id="password" placeholder="Password">
                                            @include('components.alert',['error'=>'password'])
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" required minlength="8"
                                                class="form-control form-control-user @include('components.invalid',['error'=>'confirm_password'])"
                                                name="confirm_password" id="confirm_password"
                                                placeholder="Repeat Password">
                                            @include('components.alert',['error'=>'confirm_password'])
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Verify Password
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

<script>
    var password = document.getElementById("password")
    var confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
@endsection