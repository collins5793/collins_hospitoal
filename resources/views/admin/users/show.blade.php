<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de l'utilisateur
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6">Informations générales</h3>

                <div class="space-y-4">

                    <div>
                        <span class="font-semibold">Nom :</span>
                        {{ $user->name }}
                    </div>

                    <div>
                        <span class="font-semibold">Email :</span>
                        {{ $user->email }}
                    </div>

                    <div>
                        <span class="font-semibold">Téléphone :</span>
                        {{ $user->tel ?? '-' }}
                    </div>

                    <div>
                        <span class="font-semibold">Sexe :</span>
                        {{ $user->sexe }}
                    </div>

                    <div>
                        <span class="font-semibold">Rôle :</span>
                        <span class="px-2 py-1 rounded text-white
                            {{ $user->role === 'admin' ? 'bg-blue-600' : ($user->role === 'moderateur' ? 'bg-green-600' : 'bg-gray-600') }}">
                            {{ $user->role }}
                        </span>
                    </div>

                    <div>
                        <span class="font-semibold">Compte actif :</span>
                        @if($user->active)
                            <span class="text-green-600 font-semibold">Actif</span>
                        @else
                            <span class="text-red-600 font-semibold">Inactif</span>
                        @endif
                    </div>

                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Modifier
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Retour
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
