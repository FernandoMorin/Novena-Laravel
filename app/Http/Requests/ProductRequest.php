<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/** Sirve para crear (POST) y para editar (PUT) un producto. */
class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('admin');
    }

    protected function prepareForValidation(): void
    {
        // Cada bloque del panel admin muestra sus propios errores.
        $this->errorBag = $this->isMethod('put') ? 'edit' : 'product';

        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'gt:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:4096'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }
}
