<div class="card mt-2 ml-2 text-dark">
    <ul class="list-group">
        <li class="list-group-item bg-danger text-white" aria-current="true">Merek</li>
        @foreach ($data["list_merk"] as $item_merek)
        <a href="{{ route('pages.display_by_merek', ['merek'=>$item_merek->merek_name]) }}">
            <li class="list-group-item">{{$item_merek->merek_name}}</li>
        </a>
        @endforeach
    </ul>
</div>