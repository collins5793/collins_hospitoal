<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        $patients = Patient::with('user', 'salle')->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        $salles = Salle::all();
        return view('patients.create', compact('salles'));
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'tel' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'id_salle' => 'nullable|exists:salles,id_salle',
        ]);

        // Créer le user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'sexe' => $request->sexe,
            'role' => 'patient',
        ]);

        // Créer le patient lié
        Patient::create([
            'id_user' => $user->id,
            'id_salle' => $request->id_salle,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient créé avec succès.');
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        $salles = Salle::all();
        return view('patients.edit', compact('patient', 'salles'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->id_user,
            'password' => 'nullable|string|confirmed|min:8',
            'tel' => 'nullable|string|max:20',
            'sexe' => 'required|in:M,F',
            'id_salle' => 'nullable|exists:salles,id_salle',
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

        $patient->user()->update($userData);

        // Mettre à jour le patient
        $patient->update([
            'id_salle' => $request->id_salle,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient mis à jour avec succès.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy(Patient $patient)
    {
        // Supprimer le user lié (la suppression cascade supprimera le patient)
        $patient->user()->delete();

        return redirect()->route('patients.index')->with('success', 'Patient supprimé avec succès.');
    }
}
