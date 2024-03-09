@props(['title' => 'Title', 'name' => 'Name'])

<x-partials.label :title="$title" />
<x-partials.input-text :name="$name" {{ $attributes->merge() }}/>
<x-partials.error-message :name="$name" />
