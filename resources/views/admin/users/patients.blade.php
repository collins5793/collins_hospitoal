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
<tr class="hover:bg-gray-50" x-data="{ openPaiement: false }">
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

        <!-- 🚪 Bouton Sortir le patient -->
        <form method="POST" action="{{ route('patients.quitter', $patient->patient->id_patient) }}" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                🚪 Sortir le patient
            </button>
        </form>

        <!-- 💰 Bouton Passer à la caisse -->
        <button 
            @click="openPaiement = true"
            class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            💰 Passer à la caisse
        </button>

        <!-- MODAL -->
        <div 
            x-cloak
            x-show="openPaiement"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
            x-transition
        >
            <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 relative"
                 @click.away="openPaiement = false"
                 x-transition>

                <h2 class="text-2xl font-bold mb-4 text-gray-800">💳 Paiement du patient</h2>

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->patient->id_patient }}">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Montant total</label>
                        <input type="number" step="0.01" name="montant"
                            class="w-full p-2 border rounded focus:ring focus:ring-blue-200"
                            placeholder="Ex: 15000" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Méthode de paiement</label>
                        <select name="methode" 
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-200" required>
                            <option value="">Choisir…</option>
                            <option value="cash">💵 Cash</option>
                            <option value="mobile_money">📱 Mobile Money</option>
                            <option value="carte">💳 Carte bancaire</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Notes</label>
                        <textarea name="notes" rows="3"
                                class="w-full p-2 border rounded focus:ring focus:ring-blue-200"
                                placeholder="Notes sur le paiement (optionnel)…"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button"
                                @click="openPaiement = false"
                                class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                            Annuler
                        </button>

                        <button type="submit"
                                class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Valider
                        </button>
                    </div>

                </form>
            </div>
        </div>
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
