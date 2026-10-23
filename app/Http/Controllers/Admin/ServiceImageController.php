<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceImageRequest;
use App\Models\ServiceImage;
use App\Support\AppointmentSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ServiceImageController extends Controller
{
    /**
     * Imágenes opcionales de los servicios mostrados en la landing.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => AppointmentSchedule::SERVICES,
            'images' => ServiceImage::urls(),
        ]);
    }

    /**
     * Carga o reemplaza la imagen de un servicio.
     */
    public function store(ServiceImageRequest $request): RedirectResponse
    {
        $servicio = (string) $request->validated('servicio');
        $file = $request->file('imagen');

        if (! $file instanceof UploadedFile) {
            throw ValidationException::withMessages([
                'imagen' => 'Adjunta una imagen para el servicio.',
            ]);
        }

        $image = ServiceImage::query()->where('servicio', $servicio)->first();

        if ($image instanceof ServiceImage) {
            Storage::disk('public')->delete($image->imagen);
        }

        ServiceImage::query()->updateOrCreate(
            ['servicio' => $servicio],
            ['imagen' => $file->store('servicios', 'public')],
        );

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'La imagen del servicio se guardó correctamente.',
        ]);

        return back();
    }

    /**
     * Quita la imagen de un servicio para volver al ícono predeterminado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'servicio' => ['required', 'string', Rule::in(AppointmentSchedule::SERVICES)],
        ]);

        $image = ServiceImage::query()
            ->where('servicio', (string) $data['servicio'])
            ->first();

        if ($image instanceof ServiceImage) {
            Storage::disk('public')->delete($image->imagen);
            $image->delete();
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'El servicio vuelve a mostrar su ícono.',
        ]);

        return back();
    }
}
