@extends('layouts.med') <!-- ou med.blade si c'est pour médecin -->
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Assigner {{ $patient->user->name }} à une salle
        </h2>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('patients.assigner', $patient->id_patient) }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="salle_id" :value="__('Sélectionnez une salle')" />
                <select id="salle_id" name="salle_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Choisir une salle --</option>
                    @foreach($salles as $salle)
                        <option value="{{ $salle->id_salle }}">{{ $salle->nom ?? 'Salle ' . $salle->id_salle }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('salle_id')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Assigner
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
