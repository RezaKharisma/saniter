@if ($text)
    <div {{ $attributes->merge(['class'=> 'form-text mt-1']) }}>{{ $text }}</div>
@endif
