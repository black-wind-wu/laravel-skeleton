<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)<label for="{{ $id }}" class="form-label">{{ $label }}</label>@endif
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}">{{ old($name) }}</textarea>
    @error($name)<span class="invalid-feedback" role="alert" >{{ $message }}</span>@enderror
</div>
