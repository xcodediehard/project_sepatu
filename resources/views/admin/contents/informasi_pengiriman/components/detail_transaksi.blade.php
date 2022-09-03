@csrf
<input type="hidden" name="code" value="{{$item->id}}" required>

<div class="form-group">
    <label for="exampleInputEmail1">Masukan Nomer Resi</label>
    <input type="text" class="form-control @include('components.invalid',['error'=>'resi'])" name="resi" required
        id="exampleInputresi1" aria-describedby="resiHelp">
    @include('components.alert',['error'=>'resi'])
</div>

<label for="">Masukan Foto Resi</label>
<input type="file" accept="image/*" onchange="loadFile(event)" name="image" required>
<img id="output" class="w-100 my-2" />
<script>
    var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>