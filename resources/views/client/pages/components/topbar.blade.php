<nav class="navbar navbar-expand-lg navbar-dark shadow-lg p-3 bg bg-danger">

    <a class="navbar-brand" href="{{ route('pages.home') }}">Eltoro</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('pages.home') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            @if (!empty(auth()->guard("client")->user()))
            <li class="nav-item active">
                <a class="nav-link" href="#">Keranjang <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('pages.list_transaksi') }}">Transaksi <span
                        class="sr-only">(current)</span></a>
            </li>
            @endif
        </ul>
        <hr>
        @if (!empty(auth()->guard("client")->user()))
        <h4 class="mr-2 text-white">Hai,{{auth()->guard("client")->user()->nama}} </h4>
        <a href="{{ route('user.logout') }}" class="btn btn-light border border-danger text-danger">Logout</a>
        @else
        <a href="{{ route('user.register') }}" class="btn btn-danger border border-white text-white mr-2">Register</a>
        <a href="{{ route('user.login') }}" class="btn btn-light border border-danger text-danger">Login</a>
        @endif
    </div>
</nav>