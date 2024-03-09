@props(['title' => 'Title', 'name' => 'Name'])

<x-partials.label :title="$title" />
<div class="input-group input-group-merge">
    <x-partials.input-password :name="$name" {{ $attributes->merge() }}/>
    <x-partials.error-message :name="$name" />
</div>

