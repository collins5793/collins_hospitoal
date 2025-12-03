<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des utilisateurs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
    <a href="{{ route('register') }}"
       class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        + Ajouter un utilisateur
    </a>
</div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Liste des utilisateurs</h3>

                <table class="min-w-full border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Nom</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Téléphone</th>
                            <th class="px-4 py-2 border">Sexe</th>
                            <th class="px-4 py-2 border">Rôle</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $user->id }}</td>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border">{{ $user->tel ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $user->sexe }}</td>
                                <td class="px-4 py-2 border">
                                    <span class="px-2 py-1 rounded text-white 
                                        {{ $user->role === 'admin' ? 'bg-blue-600' : ($user->role === 'moderateur' ? 'bg-green-600' : 'bg-gray-600') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 border">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                            class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                            Voir
                                        </a>

                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                            class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                            Modifier
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
