<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Salle;
use App\Models\Consultation;
use App\Models\Dossier;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // --- Statistiques globales ---
        $totalPatients = Patient::count();
        $totalMedecins = Medecin::count();
        $totalSalles = Salle::count();

        // Nombre de patients actuellement dans une salle
        $patientsEnSalle = Patient::whereNotNull('id_salle')->count();

        // Nombre de consultations aujourd'hui
        $consultationsToday = Consultation::whereDate('date', Carbon::today())->count();

        // --- Graphique : consultations par jour (dernière semaine) ---
        $consultationsPerDay = Consultation::whereDate('date', '>=', Carbon::now()->subDays(6))
            ->selectRaw('DATE(date) as jour, COUNT(*) as total')
            ->groupBy('jour')
            ->orderBy('jour', 'ASC')
            ->get()
            ->mapWithKeys(fn($item) => [$item->jour => $item->total]);

        // Compléter les jours manquants avec 0
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $last7Days[$day] = $consultationsPerDay[$day] ?? 0;
        }

        // --- Graphique : répartition des patients par salle ---
        $patientsPerSalle = Salle::withCount('patients')->get()->pluck('patients_count', 'type');

        // --- Derniers patients ajoutés ---
        $recentPatients = Patient::with('user', 'salle')->latest()->take(5)->get();

        // --- Dernières consultations ---
        $recentConsultations = Consultation::with('patient.user', 'medecin.user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPatients',
            'totalMedecins',
            'totalSalles',
            'patientsEnSalle',
            'consultationsToday',
            'last7Days',
            'patientsPerSalle',
            'recentPatients',
            'recentConsultations'
        ));
    }
}
