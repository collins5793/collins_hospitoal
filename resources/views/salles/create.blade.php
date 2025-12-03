<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter une nouvelle salle
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('salles.store') }}">
                    @csrf

                    <!-- Type de salle -->
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Type de salle')" />
                        <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required autofocus />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('salles.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 mr-2">
                            Annuler
                        </a>
                        <x-primary-button>
                            Ajouter Salle
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
