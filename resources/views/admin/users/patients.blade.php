<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des Patients
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Patients</h3>
                    <a href="{{ route('register') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Ajouter un patient
                    </a>
                </div>

                <table class="min-w-full border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nom</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Téléphone</th>
                            <th class="px-4 py-2 border">Salle</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $patient->id }}</td>
                                <td class="px-4 py-2 border">{{ $patient->name }}</td>
                                <td class="px-4 py-2 border">{{ $patient->email }}</td>
                                <td class="px-4 py-2 border">{{ $patient->tel ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ optional($patient->patient->salle)->type ?? '-' }}</td>
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('consultations.byPatient', $patient->patient->id_patient ?? 0) }}" 
                                       class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                        Dossiers
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $patients->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
