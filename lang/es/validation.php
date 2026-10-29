<?php

// Solo las reglas que usa la app; el resto cae al inglés (APP_FALLBACK_LOCALE).
return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El :attribute no es un correo válido.',
    'string' => 'El campo :attribute debe ser texto.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'image' => 'El archivo debe ser una imagen.',
    'confirmed' => 'Las contraseñas no coinciden.',
    'unique' => 'El :attribute ya está registrado.',
    'exists' => 'Selecciona una :attribute válida.',
    'gt' => ['numeric' => 'El :attribute debe ser mayor a :value.'],
    'max' => [
        'string' => 'El campo :attribute no debe pasar de :max caracteres.',
        'file' => 'La imagen no debe pesar más de :max KB.',
    ],
    'min' => ['string' => 'La :attribute debe tener al menos :min caracteres.'],

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo',
        'password' => 'contraseña',
        'slug' => 'slug',
        'description' => 'descripción',
        'display_order' => 'orden de aparición',
        'price' => 'precio',
        'category_id' => 'categoría',
        'image' => 'imagen',
    ],
];
