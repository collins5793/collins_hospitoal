@extends('layouts.med')
@section('title', 'Dossier du patient : ' . $patient->user->name)
@section('content')
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

        <div class="mb-6 flex gap-4" x-data="{ openPaiement: false, openPharmacie: false }">
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

            <!-- Envoyer à la pharmacie -->
        <button 
            @click="openPharmacie = true"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Envoyer à la pharmacie
        </button>

        <!-- MODAL PHARMACIE -->
        <div x-cloak x-show="openPharmacie" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" x-transition>
            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative" @click.away="openPharmacie = false" x-transition>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Ordonnance Pharmacie</h2>
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id_patient }}">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Médicaments</label>
                        <textarea name="medicaments" rows="4" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" placeholder="Ex: Paracétamol 500mg…"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Quantité</label>
                        <input type="text" name="quantite" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" placeholder="Ex: 2 comprimés…">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Instructions</label>
                        <textarea name="instructions" rows="3" class="w-full p-2 border rounded focus:ring focus:ring-blue-200" placeholder="Prendre après repas…"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" @click="openPharmacie = false" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">Annuler</button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
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
@endsection