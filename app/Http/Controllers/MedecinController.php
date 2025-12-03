<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    /**
     * Display a listing of medecins.
     */
    public function index()
    {
        $medecins = Medecin::with('user')->get();
        return view('medecins.index', compact('medecins'));
    }

    /**
     * Show the form for creating a new medecin.
     */
    public function create()
    {
        return view('medecins.create');
    }

    /**
     * Store a newly created medecin in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'tel' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'specialite' => 'nullable|string|max:255',
        ]);

        // Créer le user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'sexe' => $request->sexe,
            'role' => 'medecin',
        ]);

        // Créer le medecin lié
        Medecin::create([
            'id_user' => $user->id,
            'specialite' => $request->specialite,
        ]);

        return redirect()->route('medecins.index')->with('success', 'Médecin créé avec succès.');
    }

    /**
     * Show the form for editing the specified medecin.
     */
    public function edit(Medecin $medecin)
    {
        return view('medecins.edit', compact('medecin'));
    }

    /**
     * Update the specified medecin in storage.
     */
    public function update(Request $request, Medecin $medecin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $medecin->id_user,
            'password' => 'nullable|string|confirmed|min:8',
            'tel' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'specialite' => 'nullable|string|max:255',
        ]);

        // Mettre à jour le user
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'sexe' => $request->sexe,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $medecin->user()->update($userData);

        // Mettre à jour le medecin
        $medecin->update([
            'specialite' => $request->specialite,
        ]);

        return redirect()->route('medecins.index')->with('success', 'Médecin mis à jour avec succès.');
    }

    /**
     * Remove the specified medecin from storage.
     */
    public function destroy(Medecin $medecin)
    {
        // Supprimer le user lié (cascade supprimera le medecin)
        $medecin->user()->delete();

        return redirect()->route('medecins.index')->with('success', 'Médecin supprimé avec succès.');
    }
}
