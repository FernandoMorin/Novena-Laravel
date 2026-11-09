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
    'current_password' => 'La contraseña actual no es correcta.',
    'min' => [
        'string' => 'La :attribute debe tener al menos :min caracteres.',
        'numeric' => 'La :attribute debe ser al menos :min.',
    ],
    'max' => [
        'string' => 'El campo :attribute no debe pasar de :max caracteres.',
        'file' => 'La imagen no debe pesar más de :max KB.',
        'numeric' => 'La :attribute no puede ser mayor a :max.',
    ],
    'unique' => 'El :attribute ya está registrado.',
    'exists' => 'Selecciona una :attribute válida.',
    'gt' => ['numeric' => 'El :attribute debe ser mayor a :value.'],

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
        'quantity' => 'cantidad',
        'current_password' => 'contraseña actual',
    ],
];
