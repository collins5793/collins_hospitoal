@extends('layouts.med')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Consultations du médecin : {{ $medecin->user->name }} ({{ $medecin->specialite }})
        </h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($consultations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border">Patient</th>
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
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($consultation->date)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $consultation->patient->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $consultation->dossier->examen ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $consultation->dossier->prescription ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $consultation->dossier->traitement ?? '-' }}</td>
                            <td class="px-4 py-2 border flex gap-2">
                                <a href="{{ route('consultations.edit', $consultation->id_consultation) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                    Modifier
                                </a>
                                <form action="{{ route('consultations.destroy', $consultation->id_consultation) }}" method="POST" onsubmit="return confirm('Supprimer cette consultation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
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
            <p class="text-gray-500">Aucune consultation trouvée pour ce médecin.</p>
        @endif
    </div>
</div>
@endsection
