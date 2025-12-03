<x-app-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Telephone -->
        <div class="mt-4">
            <x-input-label for="tel" :value="__('Telephone')" />
            <x-text-input id="tel" class="block mt-1 w-full" type="text" name="tel" :value="old('tel')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('tel')" class="mt-2" />
        </div>

        <!-- Sexe -->
        <div class="mt-4">
            <x-input-label for="sexe" :value="__('Sexe')" />
            <select id="sexe" name="sexe" class="block mt-1 w-full" required>
                <option value="">-- Sélectionnez --</option>
                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Homme</option>
                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Femme</option>
            </select>
            <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full" required>
                <option value="">-- Sélectionnez --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="medecin" {{ old('role') == 'medecin' ? 'selected' : '' }}>Médecin</option>
                <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Specialité (médecin seulement) -->
        <div class="mt-4" id="specialite-wrapper" style="display: none;">
            <x-input-label for="specialite" :value="__('Spécialité')" />
            <x-text-input id="specialite" class="block mt-1 w-full" type="text" name="specialite" :value="old('specialite')" />
            <x-input-error :messages="$errors->get('specialite')" class="mt-2" />
        </div>

        <!-- Password (non affiché si patient) -->
        <div class="mt-4" id="password-wrapper" style="display: none;">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password (non affiché si patient) -->
        <div class="mt-4" id="password-confirm-wrapper" style="display: none;">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Créer l\'utilisateur') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const specialiteWrapper = document.getElementById('specialite-wrapper');
        const passwordWrapper = document.getElementById('password-wrapper');
        const passwordConfirmWrapper = document.getElementById('password-confirm-wrapper');

        function toggleFields() {
            if (roleSelect.value === 'medecin' || roleSelect.value === 'admin') {
                specialiteWrapper.style.display = roleSelect.value === 'medecin' ? 'block' : 'none';
                passwordWrapper.style.display = 'block';
                passwordConfirmWrapper.style.display = 'block';
            } else if (roleSelect.value === 'patient') {
                specialiteWrapper.style.display = 'none';
                passwordWrapper.style.display = 'none';
                passwordConfirmWrapper.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', toggleFields);

        window.addEventListener('DOMContentLoaded', () => {
            toggleFields();
        });
    </script>
</x-app-layout>
