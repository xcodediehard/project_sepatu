<ul class="list-group">
    <li class="list-group-item active" aria-current="true">Detail Barang</li>
    @foreach ($item->detail_barang_field as $sizing)
    <li class="list-group-item">
        <p><b>Stok : {{ $sizing->stok }}</b></p>
        <p><b>Size : {{ $sizing->size }} cm</b></p>
    </li>
    @endforeach

</ul>