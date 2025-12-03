<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dossier du patient : {{ $patient->user->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Informations patient -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-2">Informations Patient</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><strong>Nom :</strong> {{ $patient->user->name }}</div>
                <div><strong>Email :</strong> {{ $patient->user->email }}</div>
                <div><strong>Téléphone :</strong> {{ $patient->user->tel ?? '-' }}</div>
                <div><strong>Sexe :</strong> {{ $patient->user->sexe }}</div>
                <div><strong>Salle :</strong> {{ $patient->salle ? $patient->salle->type : 'Non assignée' }}</div>
            </div>
        </div>

        <div class="mb-6 flex gap-4">
            @if($patient->id_salle)
                <!-- Bouton quitter la salle -->
                <form method="POST" action="{{ route('patients.quitter', $patient->id_patient) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Quitter la salle
                    </button>
                </form>

                <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded self-center">
                    Actuellement dans : {{ $patient->salle->type ?? 'Salle inconnue' }}
                </span>
            @else
                <!-- Bouton assigner à une salle -->
                <a href="{{ route('patients.showAssignForm', $patient->id_patient) }}" 
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Envoyer dans une salle
                </a>
            @endif
        </div>


        <!-- Consultations -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Consultations</h3>

            @if($consultations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Médecin</th>
                                <th class="px-4 py-2 border">Spécialité</th>
                                <th class="px-4 py-2 border">Examen</th>
                                <th class="px-4 py-2 border">Prescription</th>
                                <th class="px-4 py-2 border">Traitement</th>
                                <th class="px-4 py-2 border">Actions</th>   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $consultation->id_consultation }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->medecin->user->name }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->medecin->specialite }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->dossier->examen ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->dossier->prescription ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $consultation->dossier->traitement ?? '-' }}</td>
                                    <td class="px-4 py-2 border">
                                        <!-- Modifier -->
                                        <a href="{{ route('consultations.edit', $consultation->id_consultation) }}" 
                                        class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                            Modifier
                                        </a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('consultations.destroy', $consultation->id_consultation) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette consultation ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $consultations->links() }}
                </div>
            @else
                <p class="text-gray-500">Aucune consultation enregistrée pour ce patient.</p>
            @endif
        </div>
    </div>
</x-app-layout>
