<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if($label)<label class="form-label">{{ $label }}</label>@endif
    <select id="{{$id}}" name="{{$name}}[]" class="form-control @error($name) is-invalid @enderror" multiple>
        @foreach($options as $name)
            <option value="{{ $name }}" selected>{{ $name }}</option>
        @endforeach
    </select>
    @error($name)<span role="alert" class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
</div>

@once
    @prepend('head')
        <link href="{{ asset(mix('/css/select2.css')) }}" rel="stylesheet">
    @endprepend
    @prepend('scripts')
<script src="{{ asset(mix('/js/select2.js')) }}"></script>
    @endprepend
@endonce

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#{{$id}}').select2({
                tags: true,
                placeholder: '{{ $placeholder }}',
                tokenSeparators: [',', ';', '，', '；', ' '],
                minimumInputLength: 0,
                language: "{{ str_replace('_', '-', app()->getLocale()) }}",
                createTag: function(params) {
                    var str = params.term.trim().replace(/[,;，；]*$/, '');
                    return { id: str, text: str };
                },
                ajax: {
                    url: "{{route('ajax.tags')}}",
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: $.map(data.data, function (d) {
                                d.id = d.name;
                                d.text = d.name;
                                return d;
                            }),
                            pagination: {
                                more: data.next_page_url
                            }
                        };
                    },
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
            });
        });
    </script>
@endpush
