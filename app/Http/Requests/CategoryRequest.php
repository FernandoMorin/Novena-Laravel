<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
{
    protected $errorBag = 'category';

    public function authorize(): bool
    {
        return $this->user()->can('admin');
    }

    /** Si no mandan slug se genera a partir del nombre, igual que en la versión PHP. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'display_order' => $this->integer('display_order'),
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
            'slug' => ['required', 'max:100', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'display_order' => ['integer'],
            'is_active' => ['boolean'],
        ];
    }
}
