<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class SalleController extends Controller
{

    private function isAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }
    }
    /**
     * Display a listing of salles.
     */
    public function index()
    {
        $this->isAdmin();

        $salles = Salle::withCount('patients')->get();
        return view('salles.index', compact('salles'));
    }

    /**
     * Show the form for creating a new salle.
     */
    public function create()
    {
                $this->isAdmin();

        return view('salles.create');
    }

    /**
     * Store a newly created salle in storage.
     */
    public function store(Request $request)
    {
                $this->isAdmin();

        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        Salle::create([
            'type' => $request->type,
        ]);

        return redirect()->route('salles.index')->with('success', 'Salle créée avec succès.');
    }

    /**
     * Show the form for editing the specified salle.
     */
    public function edit(Salle $salle)
    {
                $this->isAdmin();

        return view('salles.edit', compact('salle'));
    }

    /**
     * Update the specified salle in storage.
     */
    public function update(Request $request, Salle $salle)
    {
                $this->isAdmin();

        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $salle->update([
            'type' => $request->type,
        ]);

        return redirect()->route('salles.index')->with('success', 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified salle from storage.
     */
    public function destroy(Salle $salle)
    {
                $this->isAdmin();

        // Vérifier si la salle contient des patients avant suppression
        if ($salle->patients()->count() > 0) {
            return redirect()->route('salles.index')->with('error', 'Impossible de supprimer une salle contenant des patients.');
        }

        $salle->delete();

        return redirect()->route('salles.index')->with('success', 'Salle supprimée avec succès.');
    }


    public function showAssignForm($patientId)
    {
        $patient = Patient::with('user')->findOrFail($patientId);
        $salles = Salle::all(); // Récupérer toutes les salles disponibles

        return view('salles.assign', compact('patient', 'salles'));
    }


    // Assigner un patient à une salle
public function assignerPatient(Request $request, $patientId)
{
    $request->validate([
        'salle_id' => 'required|exists:salles,id_salle',
    ]);

    $patient = Patient::findOrFail($patientId);
    $salle = Salle::findOrFail($request->salle_id);

    if ($patient->id_salle) {
        return back()->with('error', 'Le patient est déjà assigné à une salle.');
    }

    $patient->id_salle = $salle->id_salle;
    $patient->save();

        return view('consultations.byPatientm', compact('patient', 'consultations'));
}
    /**
     * Faire quitter un patient de sa salle
     */
    public function quitterSalle($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        if (!$patient->id_salle) {
            return back()->with('error', 'Le patient n’est assigné à aucune salle.');
        }

        $salle = $patient->salle;

        $patient->id_salle = null;
        $patient->save();

        return view('consultations.byPatientm', compact('patient', 'consultations'));
    }
}
