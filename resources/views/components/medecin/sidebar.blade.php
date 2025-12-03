<aside class="w-64 h-screen bg-gray-900 text-white flex flex-col fixed">

    <!-- Logo -->
    <div class="p-6 border-b border-gray-700">
        <h1 class="text-2xl font-bold tracking-wide">medecin Panel</h1>
        <p class="text-sm text-gray-400 mt-1">Bienvenue, {{ auth()->user()->name }}</p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto mt-4">
        <ul class="space-y-2 px-4">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition
                   {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
                    <span class="text-lg"></span>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Patients -->
            <li class="pt-6 text-gray-400 uppercase text-xs">Patients</li>
            <li>
                <a href="{{ route('patients.index') }}"
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition
                   {{ request()->routeIs('patients.*') ? 'bg-gray-800' : '' }}">
                    <span class="text-lg"></span>
                    <span>Liste des patients</span>
                </a>
            </li>

            <!-- Consultations -->
            <li class="pt-6 text-gray-400 uppercase text-xs">Consultations</li>
            <li>
                <a href="{{ route('consultations.byMedecin', auth()->user()->medecin->id_medecin) }}"
                class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition
                {{ request()->routeIs('consultations.*') ? 'bg-gray-800' : '' }}">
                    <span class="text-lg"></span>
                    <span>Voir mes consultations</span>
                </a>

            </li>

            <!-- Paramètres -->
            <li class="pt-6 text-gray-400 uppercase text-xs">Paramètres</li>
            <li>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    <span class="text-lg"></span>
                    <span>Profil</span>
                </a>
            </li>

            <!-- Déconnexion -->
            <li class="pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-red-600 transition text-left">
                        <span class="text-lg"></span>
                        <span>Se déconnecter</span>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</aside>
