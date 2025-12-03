<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Salles
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Liste des salles</h3>
                    <a href="{{ route('salles.create') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Ajouter une salle
                    </a>
                </div>

                <table class="min-w-full border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Type</th>
                            <th class="px-4 py-2 border">Nombre de patients</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($salles as $salle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $salle->id }}</td>
                                <td class="px-4 py-2 border">{{ $salle->type }}</td>
                                <td class="px-4 py-2 border">{{ $salle->patients_count }}</td>
                                <td class="px-4 py-2 border flex gap-2">
                                    <a href="{{ route('salles.edit', $salle->id_salle) }}" 
                                    class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                        Modifier
                                    </a>

                                    <form action="{{ route('salles.destroy', $salle->id_salle) }}" method="POST" onsubmit="return confirm('Supprimer cette salle ?')">
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

        </div>
    </div>
</x-app-layout>
