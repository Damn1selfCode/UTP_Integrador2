<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ImageController;
use App\Models\Image; // Asegúrate de que la ruta y el namespace sean correctos
use App\Models\User; // Ajusta el espacio de nombres según la ubicación correcta
use App\Notifications\DisableUserNotification;

class ProfileController extends Controller
{
    //usuario autenticado puede acceder
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    { //ruta a la vista
        return view('profile.edit')->with([
            'user' => $request->user(),
        ]);
    }


    public function update(ProfileRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            // Verificar la contraseña actual
            if (!empty($request->current_password) && !Hash::check($request->current_password, $user->password)) {
                return redirect()
                    ->back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            $user->fill($request->validated());

            // Condición del email
            if ($user->isDirty('email')) {
                // Verificación nula
                $user->email_verified_at = null;
                // Nueva verificación
                $user->sendEmailVerificationNotification();
            }

            // Cambiar contraseña
            if (!empty($request->new_password)) {
                $user->password = Hash::make($request->new_password);

                // Verificación nula para la contraseña
                $user->email_verified_at = null;

                // Enviar notificación de verificación por correo electrónico
                $user->sendEmailVerificationNotification();
            }

            // Guardar datos
            $user->save();

            // Verificar si hay un archivo
            if ($request->hasFile('image')) {
                // Obtener la imagen actual del usuario a través de la relación
                $currentImage = $user->image;

                // Verificar si se ha alcanzado el límite de cambios de imagen (6 veces)
                if ($currentImage !== null && $currentImage->image_change_count < 6) {
                    // Ya tiene imagen
                    // Borrar imagen anterior
                    Storage::disk('images')->delete($currentImage->path);
                    // Actualizar la imagen existente
                    $currentImage->path = $request->image->store('users', 'images');
                    $currentImage->image_change_count++;
                    $currentImage->save();
                } elseif ($currentImage === null) {
                    // Si no tiene imagen, crear una nueva
                    $user->image()->create([
                        'path' => $request->image->store('users', 'images'),
                        'image_change_count' => 1,
                    ]);
                } else {
                    return redirect()
                        ->back()
                        ->withErrors(['image' => 'You can only change your profile image 6 times.'])
                        ->withInput();
                }
            }

            return redirect()
                ->route('usuarios')
                ->withSuccess('Profile edited');
        }, 5);
    }

    public function deactivate(User $user)
    {
        $user->delete(); // Esto establecerá la fecha y hora de eliminación en 'deleted_at'

        // Puedes agregar redirecciones o respuestas aquí, por ejemplo:
        return redirect()->back()->with('success', 'Usuario desactivado correctamente.');
    }
}
