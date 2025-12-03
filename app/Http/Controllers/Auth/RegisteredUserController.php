<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Vérifie que l'utilisateur est connecté et est admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès refusé : seuls les administrateurs peuvent créer un autre admin.');
        }

        return view('auth.register'); // ou 'admin.register' si tu as une vue dédiée
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Vérifie que l'utilisateur connecté est admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Accès refusé : seuls les administrateurs peuvent créer un utilisateur.');
        }

        // Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'tel' => ['nullable', 'string', 'max:20'],
            'sexe' => ['required', 'in:M,F'],
            'role' => ['required', 'in:admin,medecin,patient'],
            'specialite' => ['nullable', 'string', 'max:255'], // pour medecin
            'id_salle' => ['nullable', 'integer'],             // pour patient
        ]);

        // Création du user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'sexe' => $request->sexe,
            'role' => $request->role,
        ]);

        // Crée le modèle lié selon le rôle
        if ($request->role === 'medecin') {
            Medecin::create([
                'id_user' => $user->id,
                'specialite' => $request->specialite ?? null,
            ]);
        } elseif ($request->role === 'patient') {
            Patient::create([
                'id_user' => $user->id,
                'id_salle' => $request->id_salle ?? null,
            ]);
        }
        // admin n'a pas de modèle lié spécifique

        // Event d'inscription (notifications, etc.)
        event(new Registered($user));

        return redirect()->route('dashboard')->with('success', "Utilisateur {$user->name} ({$user->role}) créé avec succès.");
    }
}
