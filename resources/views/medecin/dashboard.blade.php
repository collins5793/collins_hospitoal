@extends('layouts.med')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Médecin</h2>
            <div class="text-gray-600">{{ \Carbon\Carbon::now()->translatedFormat('l d F Y') }}</div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#065f9e] text-white p-5 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div class="text-3xl font-bold">{{ $patientsToday }}</div>
                    <div class="text-2xl"></div>
                </div>
                <div class="mt-2 text-sm">Patients aujourd’hui</div>
            </div>

            <div class="bg-[#28a745] text-white p-5 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div class="text-3xl font-bold">{{ $consultationsToday }}</div>
                    <div class="text-2xl"></div>
                </div>
                <div class="mt-2 text-sm">Consultations aujourd’hui</div>
            </div>

            <div class="bg-[#065f9e] text-white p-5 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div class="text-3xl font-bold">{{ $patientsEnSalle }}</div>
                    <div class="text-2xl"></div>
                </div>
                <div class="mt-2 text-sm">Patients en salle</div>
            </div>

            <div class="bg-[#28a745] text-white p-5 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div class="text-3xl font-bold">{{ $ordonnancesEnAttente }}</div>
                    <div class="text-2xl"></div>
                </div>
                <div class="mt-2 text-sm">Ordonnances en attente</div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <!-- Consultations par jour -->
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-4">Consultations - Derniers 7 jours</h3>
                <canvas id="consultationsChart" height="200"></canvas>
            </div>

            <!-- Patients par salle -->
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-4">Répartition des patients par salle</h3>
                <canvas id="patientsSalleChart" height="200"></canvas>
            </div>

        </div>

        <!-- Optionnel : répartition par sexe -->
        <div class="bg-white p-5 rounded-lg shadow mb-8">
            <h3 class="font-semibold text-gray-700 mb-4">Répartition par sexe</h3>
            <canvas id="patientsSexeChart" height="150"></canvas>
        </div>

        <!-- Tableaux récents -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Derniers patients -->
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-4">Derniers patients</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nom</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Salle</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Dernière consultation</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentPatients as $patient)
                            <tr>
                                <td class="px-4 py-2">{{ $patient->user->name }}</td>
                                <td class="px-4 py-2">{{ $patient->salle?->type ?? 'Non assigné' }}</td>
                                <td class="px-4 py-2">{{ $patient->consultations()->latest()->first()?->date->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <a href="#" class="text-blue-600 hover:underline mr-2">Voir dossier</a>
                                    <a href="#" class="text-green-600 hover:underline">Prescrire</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Dernières consultations -->
            <div class="bg-white p-5 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-4">Dernières consultations</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Patient</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Dossier</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Traitement</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentConsultations as $consult)
                            <tr>
                                <td class="px-4 py-2">{{ $consult->date->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">{{ $consult->patient->user->name }}</td>
                                <td class="px-4 py-2">{{ Str::limit($consult->dossier?->consultation ?? '-', 30) }}</td>
                                <td class="px-4 py-2">{{ Str::limit($consult->dossier?->traitement ?? '-', 30) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Graphique Consultations Derniers 7 jours ---
    const ctxConsult = document.getElementById('consultationsChart').getContext('2d');
    const consultationsChart = new Chart(ctxConsult, {
        type: 'line',
        data: {
            labels: @json($last7Days->keys()->toArray()),
            datasets: [{
                label: 'Consultations',
                data: @json($last7Days->values()->toArray()),
                backgroundColor: 'rgba(6, 95, 158, 0.2)',
                borderColor: '#065f9e',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#065f9e'
            }]
        },
        options: { responsive: true }
    });

    // --- Graphique Patients par Salle ---
    const ctxSalle = document.getElementById('patientsSalleChart').getContext('2d');
    const patientsSalleChart = new Chart(ctxSalle, {
        type: 'bar',
        data: {
            labels: @json($patientsPerSalle->keys()->toArray()),
            datasets: [{
                label: 'Patients',
                data: @json($patientsPerSalle->values()->toArray()),
                backgroundColor: '#065f9e'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // --- Graphique Répartition par sexe ---
    const ctxSexe = document.getElementById('patientsSexeChart').getContext('2d');
    const patientsSexeChart = new Chart(ctxSexe, {
        type: 'pie',
        data: {
            labels: @json($patientsParSexe->keys()->toArray()),
            datasets: [{
                label: 'Patients',
                data: @json($patientsParSexe->values()->toArray()),
                backgroundColor: ['#065f9e', '#28a745']
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
