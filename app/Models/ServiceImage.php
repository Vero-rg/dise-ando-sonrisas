<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $servicio
 * @property string $imagen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'servicio',
    'imagen',
])]
class ServiceImage extends Model
{
    /**
     * Imágenes cargadas por servicio (nombre => url).
     *
     * @return array<string, string>
     */
    public static function urls(): array
    {
        $urls = [];

        foreach (self::query()->get() as $image) {
            $urls[$image->servicio] = Storage::disk('public')->url($image->imagen);
        }

        return $urls;
    }
}
