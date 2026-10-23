<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $imagen
 * @property int $orden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'imagen',
    'orden',
])]
class HeroImage extends Model
{
    /**
     * Fotos de fondo de la tarjeta principal, en orden de aparición.
     *
     * @return list<string>
     */
    public static function urls(): array
    {
        $urls = [];

        $images = self::query()->orderBy('orden')->orderBy('id')->get();

        foreach ($images as $image) {
            $urls[] = Storage::disk('public')->url($image->imagen);
        }

        return $urls;
    }

    /**
     * @return list<array{id: int, url: string}>
     */
    public static function gallery(): array
    {
        $images = [];

        $records = self::query()->orderBy('orden')->orderBy('id')->get();

        foreach ($records as $image) {
            $images[] = [
                'id' => $image->id,
                'url' => Storage::disk('public')->url($image->imagen),
            ];
        }

        return $images;
    }
}
