@if($label)
<label for="">{{$label}}</label>
@endif


<input type="{{$type}}" name="{{$name}}" class="form-control 
@error($name) is-invalid @enderror"
    id="name"
    value="{{ old($name, $value) }}"
>

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror