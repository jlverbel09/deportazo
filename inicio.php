<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deportazo - El Corazón Digital del Voleibol de Madrid</title>
    <link rel="icon" href="https://deportazo.com/corazonlatino/dist/assets/img/logo2.png" type="image/x-icon">
    <meta name="theme-color" content="#1e40af">
    <meta name="description" content="Plataforma interactiva para el registro de campeonatos, deportistas interesados en formar parte de la comunidad deportiva en Madrid - España.">
    <meta property="og:title" content="Deportazo - El Corazón Digital del Voleibol de Madrid">
    <meta property="og:description" content="Plataforma interactiva para el registro de campeonatos y deportistas en Madrid.">
    <meta property="og:image" content="https://deportazo.com/corazonlatino/dist/assets/img/logo2.png">
    <meta property="og:url" content="https://deportazo.com">
    <meta property="og:type" content="website">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#f59e0b',
                        accent: '#dc2626'
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css">
</head>

<body class="font-['Inter'] bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-md border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="./dist/assets/img/logo.png" alt="Deportazo Logo" class="h-12 w-auto">
                    <span class="text-white font-bold text-xl">Deportazo</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#inicio" class="text-white hover:text-blue-200 transition-colors">Inicio</a>
                    <a href="#torneos" class="text-white hover:text-blue-200 transition-colors">Torneos</a>
                    <a href="#equipos" class="text-white hover:text-blue-200 transition-colors">Equipos</a>
                    <a href="#contacto" class="text-white hover:text-blue-200 transition-colors">Contacto</a>
                </div>
                <div class="flex space-x-4">
                    <a href="./dist/pages/login.php" class="bg-white text-blue-900 px-6 py-2 rounded-full font-medium hover:bg-blue-50 transition-colors">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-white">
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        El Corazón Digital del
                        <span class="text-yellow-400">Voleibol</span> de Madrid
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                        Deportazo es la plataforma online esencial para la comunidad de voleibol de Madrid, diseñada para centralizar y simplificar la vida deportiva de equipos, organizadores y jugadores.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="./dist/pages/login.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-4 rounded-full font-semibold text-lg transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-play-circle mr-2"></i>
                            Comenzar Ahora
                        </a>
                        <a href="#grupos" class="border-2 border-white text-white hover:bg-white hover:text-blue-900 px-8 py-4 rounded-full font-semibold text-lg transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-users mr-2"></i>
                            Ver Grupos
                        </a>
                    </div>
                </div>

                <!-- Featured Image/Stats -->
                <div class="lg:text-right">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-400 mb-2">50+</div>
                                <div class="text-blue-100">Equipos Registrados</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-400 mb-2">20+</div>
                                <div class="text-blue-100">Torneos Organizados</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-400 mb-2">100+</div>
                                <div class="text-blue-100">Jugadores Activos</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-400 mb-2">Madrid</div>
                                <div class="text-blue-100">Comunidad</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-32 h-32 bg-yellow-400 rounded-full blur-xl"></div>
            <div class="absolute bottom-20 right-20 w-48 h-48 bg-blue-400 rounded-full blur-xl"></div>
        </div>
    </section>

    <!-- Grupos Asociados Section -->
    <section id="grupos" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Grupos Asociados</h2>
                <p class="text-xl text-gray-600">Conoce los equipos que forman parte de nuestra comunidad</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Corazón Latino -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-shadow">
                    <img src="./dist/assets/img/grupos/corazonlatino.png" alt="Corazón Latino" class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-white">
                    <h3 class="text-2xl font-bold mb-4">Corazón Latino</h3>
                    <p class="text-blue-100 mb-6">Pasión por el voleibol en el corazón de Madrid</p>
                    <a href="./" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Visitar
                    </a>
                </div>

                <!-- Latin Force -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-shadow">
                    <img src="./dist/assets/img/grupos/latinforce.jpg" alt="Latin Force" class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-white object-cover">
                    <h3 class="text-2xl font-bold mb-4">Latin Force</h3>
                    <p class="text-red-100 mb-6">Fuerza y determinación en cada partido</p>
                    <a href="./" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Visitar
                    </a>
                </div>

                <!-- Más grupos pueden agregarse aquí -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-shadow opacity-75">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-white bg-white/20 flex items-center justify-center">
                        <i class="fas fa-plus text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Únete</h3>
                    <p class="text-green-100 mb-6">¿Tienes un equipo? Regístrate ahora</p>
                    <a href="./dist/pages/login.php" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 font-medium">
                        <i class="fas fa-user-plus mr-2"></i>
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <img src="./dist/assets/img/logo.png" alt="Deportazo" class="h-12 w-auto mb-4">
                    <p class="text-gray-400">El corazón digital del voleibol de Madrid</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Plataforma</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Torneos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Equipos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Jugadores</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Comunidad</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Grupos Asociados</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Calendario</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Resultados</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>info@deportazo.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Madrid, España</li>
                        <li><i class="fas fa-phone mr-2"></i>+34 123 456 789</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Deportazo. Todos los derechos reservados. Desarrollado por GeorkingWeb</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="./dist/js/login.js"></script>
</body>
</html>