@props(['title' => 'Title', 'name' => 'Name'])

<div class="mb-3">
<x-partials.label :title="$title" />
<x-partials.input-number :name="$name" {{ $attributes->merge() }}/>
<x-partials.error-message :name="$name" />
</div>
