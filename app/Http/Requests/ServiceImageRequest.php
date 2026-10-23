<?php

namespace App\Http\Requests;

use App\Support\AppointmentSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceImageRequest extends FormRequest
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
            'servicio' => ['required', 'string', Rule::in(AppointmentSchedule::SERVICES)],
            'imagen' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'servicio.required' => 'Selecciona el servicio.',
            'servicio.in' => 'Selecciona un servicio válido.',
            'imagen.required' => 'Adjunta una imagen para el servicio.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'Usa una imagen JPG, PNG o WEBP.',
            'imagen.max' => 'La imagen no puede superar los 2 MB.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'servicio' => 'servicio',
            'imagen' => 'imagen del servicio',
        ];
    }
}
