<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Administrateur
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1Statistiques globales -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-[#28a745] text-white rounded-lg shadow p-5 flex flex-col items-center justify-center transform hover:scale-105 transition">
                    <h3 class="text-lg font-semibold">Total Patients</h3>
                    <span class="text-3xl font-bold mt-2">{{ $totalPatients }}</span>
                </div>

                <div class="bg-[#065f9e] text-white rounded-lg shadow p-5 flex flex-col items-center justify-center transform hover:scale-105 transition">
                    <h3 class="text-lg font-semibold">Total Médecins</h3>
                    <span class="text-3xl font-bold mt-2">{{ $totalMedecins }}</span>
                </div>

                <div class="bg-green-700 text-white rounded-lg shadow p-5 flex flex-col items-center justify-center transform hover:scale-105 transition">
                    <h3 class="text-lg font-semibold">Patients en salle</h3>
                    <span class="text-3xl font-bold mt-2">{{ $patientsEnSalle }}</span>
                </div>

                <div class="bg-blue-700 text-white rounded-lg shadow p-5 flex flex-col items-center justify-center transform hover:scale-105 transition">
                    <h3 class="text-lg font-semibold">Consultations aujourd'hui</h3>
                    <span class="text-3xl font-bold mt-2">{{ $consultationsToday }}</span>
                </div>
            </div>

            <!-- 2 Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Graphique Consultations Derniers 7 jours -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Consultations - Derniers 7 jours</h3>
                    <canvas id="consultationsChart" class="w-full h-64"></canvas>
                </div>

                <!-- Graphique Répartition patients par salle -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Patients par Salle</h3>
                    <canvas id="patientsSalleChart" class="w-full h-64"></canvas>
                </div>

            </div>

            <!-- 3 Derniers Patients -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Derniers Patients</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Nom</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Téléphone</th>
                                <th class="px-4 py-2 border">Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPatients as $patient)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $patient->user->name }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->user->email }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->user->tel ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $patient->salle->type ?? 'Non assignée' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4️⃣ Dernières Consultations -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Dernières Consultations</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Patient</th>
                                <th class="px-4 py-2 border">Médecin</th>
                                <th class="px-4 py-2 border">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentConsultations as $consultation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $consultation->patient->user->name }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->medecin->user->name }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($consultation->date)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: '#28a745',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
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
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

    </script>
</x-app-layout>
