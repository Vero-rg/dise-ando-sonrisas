<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'imagenes' => ['required', 'array', 'min:1', 'max:8'],
            'imagenes.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'imagenes.required' => 'Selecciona al menos una foto.',
            'imagenes.array' => 'Las fotos no se recibieron correctamente.',
            'imagenes.min' => 'Selecciona al menos una foto.',
            'imagenes.max' => 'Sube máximo 8 fotos a la vez.',
            'imagenes.*.image' => 'Cada archivo debe ser una imagen.',
            'imagenes.*.mimes' => 'Usa imágenes JPG, PNG o WEBP.',
            'imagenes.*.max' => 'Cada imagen no puede superar los 4 MB.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'imagenes' => 'fotos',
            'imagenes.*' => 'foto',
        ];
    }
}
