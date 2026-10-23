<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroImageRequest;
use App\Models\HeroImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class HeroImageController extends Controller
{
    /**
     * Fotos que se alternan como fondo de la tarjeta principal.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Hero/Index', [
            'images' => HeroImage::gallery(),
        ]);
    }

    /**
     * Agrega una o varias fotos a la portada.
     */
    public function store(HeroImageRequest $request): RedirectResponse
    {
        $files = $request->file('imagenes', []);
        $files = is_array($files) ? $files : [$files];

        $orden = (int) HeroImage::query()->max('orden');
        $saved = 0;

        foreach ($files as $file) {
            $orden++;

            HeroImage::create([
                'imagen' => $file->store('portada', 'public'),
                'orden' => $orden,
            ]);

            $saved++;
        }

        if ($saved === 0) {
            throw ValidationException::withMessages([
                'imagenes' => 'Selecciona al menos una foto.',
            ]);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $saved === 1
                ? 'La foto se agregó a la portada.'
                : "Se agregaron {$saved} fotos a la portada.",
        ]);

        return back();
    }

    /**
     * Elimina una foto de la portada.
     */
    public function destroy(HeroImage $heroImage): RedirectResponse
    {
        Storage::disk('public')->delete($heroImage->imagen);

        $heroImage->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'La foto se eliminó de la portada.',
        ]);

        return back();
    }
}
