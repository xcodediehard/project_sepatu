@extends('client.auth.auth_template')

@section('auth_content')
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{ asset('illustration') }}/register.png" alt="{{ asset('illustration') }}/register.png"
                        class="w-100">
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            @include('components.notify')
                        </div>
                        <form class="user" action="{{ route('user.register_proses') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" required
                                        class="form-control form-control-user @include('components.invalid',['error'=>'nama'])"
                                        name="nama" id="exampleFirstName" placeholder="Nama">
                                    @include('components.alert',['error'=>'nama'])
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" required maxlength="15"
                                        class="form-control form-control-user @include('components.invalid',['error'=>'telfon'])"
                                        name="telfon" id="exampleLastName" placeholder="Telfon">
                                    @include('components.alert',['error'=>'telfon'])
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" required
                                    class="form-control form-control-user @include('components.invalid',['error'=>'email'])"
                                    name="email" id="exampleInputEmail" placeholder="Email ">
                                @include('components.alert',['error'=>'email'])
                            </div>
                            <div class="form-group">
                                <textarea
                                    class="form-control form-control-user @include('components.invalid',['error'=>'alamat'])"
                                    name="alamat" id="exampleInputalamat" placeholder="alamat "></textarea>
                            </div>
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
                                        name="confirm_password" id="confirm_password" placeholder="Repeat Password">
                                    @include('components.alert',['error'=>'confirm_password'])
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('user.forpass') }}">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('user.login') }}">Already have an account? Login!</a>
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