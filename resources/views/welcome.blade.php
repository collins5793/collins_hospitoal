<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSys - Digitalisez votre hôpital</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-up {
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover:hover {
            transform: translateY(-6px);
            transition: 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- 🌐 NAVBAR -->
    <header class="w-full bg-white fixed top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
            <div class="text-2xl font-bold text-blue-700">MedSys</div>

            <nav class="hidden md:flex space-x-8 text-sm font-medium">
                <a href="#" class="hover:text-blue-600">Accueil</a>
                <a href="#" class="hover:text-blue-600">À propos</a>
            </nav>

            <div class="flex space-x-4">
                <a href="/login" class="text-blue-700 font-semibold">Connexion</a>
                <a href="#"
                   class="px-4 py-2 bg-blue-700 text-white rounded-lg shadow hover:bg-blue-800 transition">
                    Demander une démo
                </a>
            </div>
        </div>
    </header>


    <!-- 🏥 HERO SECTION -->
    <section class="pt-40 pb-24 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

            <div class="fade-up">
                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                    La plateforme moderne pour <span class="text-blue-700">digitaliser</span> votre hôpital.
                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                    Admissions, consultations, gestion des lits, dossiers médicaux, statistiques…  
                    Tout dans un système unique, sécurisé et simple.
                </p>

                
            </div>

            <div class="fade-up delay-200">
                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/medical-dashboard-3d-illustration-download-in-png-blend-fbx-gltf-file-formats--report-statistics-hospital-pack-healthcare-illustrations-8315790.png"
                     class="w-full drop-shadow-xl" alt="Dashboard médical">
            </div>

        </div>
    </section>


    <!-- ⭐ FONCTIONNALITÉS -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16">
                Fonctionnalités principales
            </h2>

            <div class="grid md:grid-cols-3 gap-10">

                <!-- Carte -->
                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Dossier médical électronique</h3>
                    <p class="text-gray-600">Accédez aux données complètes des patients en un clic.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Gestion des consultations</h3>
                    <p class="text-gray-600">Planification, prescriptions, examens, historique complet.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Suivi des salles et lits</h3>
                    <p class="text-gray-600">Suivi en temps réel de l’occupation et disponibilité.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Administration centralisée</h3>
                    <p class="text-gray-600">Gestion des médecins, infirmiers, patients et services.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Statistiques & rapports</h3>
                    <p class="text-gray-600">Graphiques dynamiques sur les performances médicales.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow card-hover">
                    <h3 class="text-xl font-semibold mb-3">Gestion des admissions</h3>
                    <p class="text-gray-600">Process simplifié, rapide et conforme aux standards.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- 📞 CONTACT / SUPPORT -->
    <section id="contact" class="py-24 bg-blue-50">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            
            <div>
                <h2 class="text-4xl font-bold mb-6">Support & Assistance</h2>
                <p class="text-gray-700 mb-4">Nous sommes disponibles pour répondre à vos préoccupations.</p>

                <p class="font-medium text-gray-800">📧 support@medsys.com</p>
                <p class="font-medium text-gray-800 mt-2">📞 +229 60 00 00 00</p>
                <p class="font-medium text-gray-800 mt-2">⏱ Disponible 24/7</p>
            </div>

            <form class="bg-white p-8 rounded-xl shadow space-y-4">
                <input type="text" placeholder="Nom complet" class="w-full p-3 border rounded">
                <input type="email" placeholder="Email" class="w-full p-3 border rounded">
                <textarea placeholder="Message" rows="4" class="w-full p-3 border rounded"></textarea>

                <button class="w-full bg-blue-700 text-white py-3 rounded-lg">
                    Envoyer
                </button>
            </form>

        </div>
    </section>


    


    <!-- ⚫ FOOTER -->
    <footer class="py-8 text-center bg-gray-900 text-gray-300">
        <p class="font-semibold text-lg">MedSys</p>
        <p class="text-sm mt-2">© {{ date('Y') }} Tous droits réservés.</p>

        <div class="text-xs mt-4">
            <a href="#" class="hover:text-white mx-2">Mentions légales</a>
            <a href="#" class="hover:text-white mx-2">Confidentialité</a>
            <a href="#" class="hover:text-white mx-2">Contact</a>
        </div>
    </footer>

</body>
</html>
