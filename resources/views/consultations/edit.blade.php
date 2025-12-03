@extends('layouts.med')

@section('content')
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Modifier Consultation</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('consultations.update', $consultation->id_consultation) }}">
                @csrf
                @method('PUT')

                <!-- Patient -->
                <div class="mb-4">
                    <x-input-label for="id_patient" :value="__('Patient')" />
                    <select id="id_patient" name="id_patient" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Sélectionnez un patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id_patient }}" {{ $consultation->id_patient == $patient->id_patient ? 'selected' : '' }}>
                                {{ $patient->user->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('id_patient')" class="mt-2" />
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <x-input-label for="date" :value="__('Date de consultation')" />
                    <x-text-input id="date" type="datetime-local" name="date" value="{{ \Carbon\Carbon::parse($consultation->date)->format('Y-m-d\TH:i') }}" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>

                <!-- Consultation (texte) -->
                <div class="mb-4">
                    <x-input-label for="consultation" :value="__('Motif de consultation')" />
                    <textarea id="consultation" name="consultation" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('consultation', $consultation->dossier->consultation ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('consultation')" class="mt-2" />
                </div>

                <!-- Examen -->
                <div class="mb-4">
                    <x-input-label for="examen" :value="__('Examen(s)')" />
                    <textarea id="examen" name="examen" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('examen', $consultation->dossier->examen ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('examen')" class="mt-2" />
                </div>

                <!-- Prescription -->
                <div class="mb-4">
                    <x-input-label for="prescription" :value="__('Prescription')" />
                    <textarea id="prescription" name="prescription" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('prescription', $consultation->dossier->prescription ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('prescription')" class="mt-2" />
                </div>

                <!-- Traitement -->
                <div class="mb-4">
                    <x-input-label for="traitement" :value="__('Traitement')" />
                    <textarea id="traitement" name="traitement" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('traitement', $consultation->dossier->traitement ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('traitement')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <a href="{{ route('consultations.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-yellow-700 transition">
                        Mettre à jour Consultation
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
