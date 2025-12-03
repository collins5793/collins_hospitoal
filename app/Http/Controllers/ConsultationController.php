<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;


class ConsultationController extends Controller
{
    /**
     * Vérifie que l'utilisateur est admin
     */
    private function isAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }
    }
    private function isMedecin()
    {
        if (!Auth::check() || Auth::user()->role !== 'medecin') {
            abort(403, 'Accès non autorisé.');
        }
    }

    /**
     * Liste des consultations
     */
    public function index()
    {
        $this->isAdmin();

        $consultations = Consultation::with(['patient.user', 'medecin.user', 'dossier'])
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('consultations.index', compact('consultations'));
    }

    /**
     * Afficher une consultation spécifique
     */
    public function show($id)
    {
        $this->isAdmin();

        $consultation = Consultation::with(['patient.user', 'medecin.user', 'dossier'])->findOrFail($id);

        return view('consultations.show', compact('consultation'));
    }

    /**
     * Formulaire pour créer une nouvelle consultation
     */
    public function create()
    {
        $this->isMedecin();

        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();

        return view('consultations.create', compact('patients', 'medecins'));
    }

    /**
     * Stocker une nouvelle consultation
     */
   public function store(Request $request)
    {
        // Vérifier que c'est un médecin
        $medecin = Auth::user()->medecin;
        if (!$medecin) {
            abort(403, "Accès non autorisé.");
        }

        // Validation
        $request->validate([
            'id_patient'   => 'required|exists:patients,id_patient',
            'date'         => 'required|date',
            'consultation' => 'required|string',
            'examen'       => 'nullable|string',
            'prescription' => 'nullable|string',
            'traitement'   => 'nullable|string',
        ]);

        // Créer le dossier
        $dossier = Dossier::create([
            'id_patient'   => $request->id_patient,
            'id_medecin'   => $medecin->id_medecin,
            'consultation' => $request->consultation,
            'examen'       => $request->examen,
            'prescription' => $request->prescription,
            'traitement'   => $request->traitement,
        ]);

        // Créer la consultation liée
        Consultation::create([
            'id_patient' => $request->id_patient,
            'id_medecin' => $medecin->id_medecin,
            'id_dossier' => $dossier->id_dossier,
            'date'       => $request->date,
        ]);

        return redirect()->route('consultations.bypatientm', $request->id_patient)
                         ->with('success', 'Consultation et dossier créés avec succès.');
    }

    /**
     * Formulaire pour éditer une consultation
     */
    public function edit($id)
    {
        $this->isMedecin();

        $consultation = Consultation::findOrFail($id);
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();

        return view('consultations.edit', compact('consultation', 'patients', 'medecins'));
    }

    /**
     * Mettre à jour une consultation
     */
  
    public function update(Request $request, $id)
    {
        $medecin = Auth::user()->medecin;
        if (!$medecin) {
            abort(403, "Accès non autorisé.");
        }

        $consultation = Consultation::findOrFail($id);
        $dossier = $consultation->dossier;

        // Validation
        $request->validate([
            'id_patient'   => 'required|exists:patients,id_patient',
            'date'         => 'required|date',
            'consultation' => 'required|string',
            'examen'       => 'nullable|string',
            'prescription' => 'nullable|string',
            'traitement'   => 'nullable|string',
        ]);

        // Mettre à jour le dossier
        if ($dossier) {
            $dossier->update([
                'id_patient'   => $request->id_patient,
                'id_medecin'   => $medecin->id_medecin,
                'consultation' => $request->consultation,
                'examen'       => $request->examen,
                'prescription' => $request->prescription,
                'traitement'   => $request->traitement,
            ]);
        }

        // Mettre à jour la consultation
        $consultation->update([
            'id_patient' => $request->id_patient,
            'id_medecin' => $medecin->id_medecin,
            'date'       => $request->date,
        ]);

        return redirect()->route('consultations.byPatientm', $request->id_patient)
                         ->with('success', 'Consultation et dossier mis à jour avec succès.');
    }

    /**
     * Supprimer une consultation
     */
    public function destroy($id)
    {
        $this->isAdmin();

        $consultation = Consultation::findOrFail($id);
        $consultation->delete();

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation supprimée avec succès.');
    }

    /**
     * Liste des consultations par patient
     */
    public function byPatients($patientId)
    {
        $this->isAdmin();

        $patient = Patient::with('user')->findOrFail($patientId);
        $consultations = $patient->consultations()->with('medecin.user', 'dossier')->paginate(15);

        return view('consultations.byPatient', compact('patient', 'consultations'));
    }

    public function byPatient($patientId)
    {
        $this->isMedecin();

        $patient = Patient::with('user')->findOrFail($patientId);
        $consultations = $patient->consultations()->with('medecin.user', 'dossier')->paginate(15);

        return view('consultations.byPatientm', compact('patient', 'consultations'));
    }

    /**
     * Liste des consultations par médecin
     */
    public function byMedecin($medecinId)
    {

        $medecin = Medecin::with('user')->findOrFail($medecinId);
        $consultations = $medecin->consultations()->with('patient.user', 'dossier')->paginate(15);

        return view('consultations.byMedecin', compact('medecin', 'consultations'));
    }
}
