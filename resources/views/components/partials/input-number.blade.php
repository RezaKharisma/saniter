<?php
    $class = 'form-control';

    // Jika input terdapat error validasi
    if ($errors->has($name)) {
        $class = 'form-control is-invalid';
    }
?>
<input type="number" {{ $attributes->merge(['class' => $class]) }}>

