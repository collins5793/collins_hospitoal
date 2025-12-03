<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\Salle;
use App\Models\Consultation;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function dashboard()
    {
        $medecin = Auth::user()->medecin;

        // --- Statistiques rapides ---
        $patientsToday = Patient::whereHas('consultations', function($q) use ($medecin) {
            $q->where('id_medecin', $medecin->id_medecin)
              ->whereDate('date', Carbon::today());
        })->count();

        $consultationsToday = Consultation::where('id_medecin', $medecin->id_medecin)
            ->whereDate('date', Carbon::today())
            ->count();

        $patientsEnSalle = Patient::where('id_salle', '!=', null)
            ->whereHas('consultations', fn($q) => $q->where('id_medecin', $medecin->id_medecin))
            ->count();

        $ordonnancesEnAttente = Dossier::where('id_medecin', $medecin->id_medecin)
            ->whereNotNull('prescription')
            ->whereDoesntHave('consultationLink') // pas encore traitée
            ->count();

        // --- Graphique : consultations par jour (dernière semaine) ---
        $consultationsPerDay = Consultation::where('id_medecin', $medecin->id_medecin)
            ->whereDate('date', '>=', Carbon::now()->subDays(6))
            ->selectRaw('DATE(date) as jour, COUNT(*) as total')
            ->groupBy('jour')
            ->orderBy('jour', 'ASC')
            ->get()
            ->mapWithKeys(fn($item) => [$item->jour => $item->total]);

        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $last7Days[$day] = $consultationsPerDay[$day] ?? 0;
        }

        // --- Graphique : répartition des patients par salle ---
        $patientsPerSalle = Salle::withCount(['patients' => fn($q) => $q->whereHas('consultations', fn($q2) => $q2->where('id_medecin', $medecin->id_medecin))])
            ->get()
            ->pluck('patients_count', 'type');

        // --- Graphique optionnel : répartition par sexe ---
        $patientsParSexe = Patient::whereHas('consultations', fn($q) => $q->where('id_medecin', $medecin->id_medecin))
            ->with('user')
            ->get()
            ->groupBy(fn($p) => $p->user->sexe)
            ->map(fn($group) => $group->count());

        // --- Derniers patients ---
        $recentPatients = Patient::whereHas('consultations', fn($q) => $q->where('id_medecin', $medecin->id_medecin))
            ->with('user', 'salle')
            ->latest()
            ->take(5)
            ->get();

        // --- Dernières consultations ---
        $recentConsultations = Consultation::where('id_medecin', $medecin->id_medecin)
            ->with('patient.user', 'dossier')
            ->latest()
            ->take(5)
            ->get();

        return view('medecin.dashboard', compact(
            'medecin',
            'patientsToday',
            'consultationsToday',
            'patientsEnSalle',
            'ordonnancesEnAttente',
            'last7Days',
            'patientsPerSalle',
            'patientsParSexe',
            'recentPatients',
            'recentConsultations'
        ));
    }
}
