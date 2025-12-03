<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Consultations
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Liste des consultations</h3>
                    @if(auth()->user()->role === 'medecin')
                        <a href="{{ route('admin.consultations.create') }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Ajouter une consultation
                        </a>
                    @endif

                </div>

                <table class="min-w-full border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Patient</th>
                            <th class="px-4 py-2 border">Médecin</th>
                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($consultations as $consultation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $consultation->id_consultation }}</td>
                                <td class="px-4 py-2 border">{{ $consultation->patient->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $consultation->medecin->user->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $consultation->date }}</td>
                                <td class="px-4 py-2 border flex gap-2">
                                    <a href="{{ route('admin.consultations.show', $consultation->id_consultation) }}" 
                                       class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                        Voir
                                    </a>
                                    <a href="{{ route('admin.consultations.edit', $consultation->id_consultation) }}" 
                                       class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                        Modifier
                                    </a>
                                    <form action="{{ route('admin.consultations.destroy', $consultation->id_consultation) }}" method="POST" onsubmit="return confirm('Supprimer cette consultation ?')">
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

                <div class="mt-4">
                    {{ $consultations->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
