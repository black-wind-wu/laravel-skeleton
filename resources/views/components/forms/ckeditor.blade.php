<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)<label class="form-label">{{ $label }}</label>@endif
    <textarea id="{{$id}}" name="{{$name}}" class="form-control @error($name) is-invalid @enderror" placeholder="{{$placeholder}}">{{$value}}</textarea>
    @error($name)<span role="alert" class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
</div>

@once
    @prepend('scripts')
<script src="{{ asset(mix('/js/ckeditor.js')) }}"></script>
    @endprepend
@endonce

@push('scripts')
    <script>
        ClassicEditor.create(document.querySelector('#{{$id}}'), {
            language: 'zh-cn',
            link: {
                defaultProtocol: 'https://',
                addTargetToExternalLinks: true
            },
            ckfinder: {
                uploadUrl: '{{route('uploader.ckeditor')}}',
            },
        }).catch(error => {
            console.error(error);
        });
    </script>
@endpush
