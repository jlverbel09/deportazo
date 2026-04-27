<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deportazo - El Corazón Digital del Voleibol de Madrid</title>
    <link rel="icon" href="https://deportazo.com/dist/assets/img/logo2.png" type="image/x-icon">
    <meta name="theme-color" content="#1e40af">
    <meta name="description" content="Plataforma interactiva para el registro de campeonatos, deportistas interesados en formar parte de la comunidad deportiva en Madrid - España.">
    <meta property="og:title" content="Deportazo - El Corazón Digital del Voleibol de Madrid">
    <meta property="og:description" content="Plataforma interactiva para el registro de campeonatos y deportistas en Madrid.">
    <meta property="og:image" content="https://deportazo.com/dist/assets/img/logo2.png">
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

    <style>
        body {
            background-color: #0f172a;
        }

        .hero-bg {
            background-image:
                linear-gradient(180deg, rgba(15, 23, 42, 0.88) 0%, rgba(15, 23, 42, 0.5) 45%, rgba(15, 23, 42, 0.82) 100%),
                url('./dist/assets/img/portadas/22.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('./dist/assets/img/portadas/11.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.14;
            mix-blend-mode: screen;
        }

        .hero-bg .hero-content,
        .hero-bg .hero-stats {
            position: relative;
            z-index: 10;
        }

        .featured-card {
            background: rgba(15, 23, 42, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 20px 80px rgba(15, 23, 42, 0.35);
        }

        .background-voley {
            background-image: url('./dist/assets/img/portadas/33.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="font-['Inter'] min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-md border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="./dist/assets/img/logo.png" alt="Deportazo Logo" class="h-12 w-auto">
                    
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#inicio" class="text-white hover:text-blue-200 transition-colors">Inicio</a>
                    <a href="#torneo" class="text-white hover:text-blue-200 transition-colors">Torneo</a>
                    <a href="#grupos" class="text-white hover:text-blue-200 transition-colors">Grupos</a>
                    <a href="#contacto" class="text-white hover:text-blue-200 transition-colors">Contacto</a>
                </div>
                <div class="flex space-x-4">
                    <a href="#grupos" class="bg-white text-blue-900 px-6 py-2 rounded-full font-medium hover:bg-blue-50 transition-colors">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="relative min-h-screen flex items-center hero-bg overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950/80 via-slate-950/20 to-slate-950/80"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="hero-content text-white">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm uppercase tracking-[0.2em] text-slate-200 mb-6">
                        <i class="fas fa-volleyball-ball"></i>
                        Comunidad de voleibol
                    </span>
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        El Corazón Digital del
                        <span class="text-yellow-400">Voleibol</span> de Madrid
                    </h1>
                    <p class="text-xl mb-8 text-slate-200 leading-relaxed max-w-2xl">
                        Deportazo centraliza la gestión de torneos, equipos y resultados para la comunidad deportiva de Madrid. Organiza partidos, gestiona plantillas y mantente conectado con tus rivales en una plataforma moderna.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                       <!--  <a href="./dist/pages/login.php" class="bg-yellow-500 hover:bg-yellow-600 text-slate-950 px-8 py-4 rounded-full font-semibold text-lg transition-colors inline-flex items-center justify-center shadow-lg shadow-yellow-500/20">
                            <i class="fas fa-play-circle mr-2"></i>
                            Comenzar Ahora
                        </a> -->
                        <a href="#grupos" class="border border-white/20 text-white hover:bg-white hover:text-slate-950 px-8 py-4 rounded-full font-semibold text-lg transition-colors inline-flex items-center justify-center">
                            <i class="fas fa-users mr-2"></i>
                            Ver Grupos
                        </a>
                    </div>
                </div>

                <!-- Featured Cards -->
                <div class="hero-stats grid gap-6">
                    <div class="featured-card rounded-3xl p-8 text-white">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm uppercase tracking-[0.2em] text-slate-300">Estadísticas</p>
                                <h2 class="text-3xl font-bold">
                                    <?php
                                    try {
                                        require_once './dist/pages/conexion.php';
                                        $torneosCount = $conexion->query("SELECT COUNT(*) as total FROM torneo WHERE status != 2")->fetch();
                                        echo '+' . $torneosCount['total'];
                                    } catch (Exception $e) {
                                        echo '+120';
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="rounded-3xl bg-slate-950/30 p-4 text-yellow-400">
                                <i class="fas fa-trophy fa-lg"></i>
                            </div>
                        </div>
                        <p class="text-slate-300">Torneos ya gestionados dentro de la plataforma.</p>
                    </div>
                    <div class="featured-card rounded-3xl p-8 text-white background-voley">
                        <div class="bg-slate-950/60 rounded-3xl p-6">
                            <p class="text-sm uppercase tracking-[0.2em] text-slate-300">Experiencia</p>
                            <h2 class="text-3xl font-bold">Jugadores conectados</h2>
                            <p class="mt-4 text-slate-200">Equipos, plantillas y calendario en un solo lugar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Soft graphic elements -->
        <div class="absolute top-10 right-10 w-24 h-24 rounded-full bg-yellow-400/30 blur-3xl"></div>
        <div class="absolute bottom-16 left-8 w-28 h-28 rounded-full bg-white/10 blur-3xl"></div>
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
                    <a target="_blank" href="./corazonlatino/" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Acceder
                    </a>
                </div>

                <!-- Latin Force -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-shadow">
                    <img src="./dist/assets/img/grupos/latinforce2.jpg" alt="Latin Force" class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-white object-cover">
                    <h3 class="text-2xl font-bold mb-4">Latin Force</h3>
                    <p class="text-red-100 mb-6">Fuerza y determinación en cada partido</p>
                    <a target="_blank" href="./latinforce" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Acceder
                    </a>
                </div>

                <!-- Más grupos pueden agregarse aquí -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-8 text-white text-center hover:shadow-2xl transition-shadow opacity-75">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full border-4 border-white bg-white/20 flex items-center justify-center">
                        <i class="fas fa-plus text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Únance</h3>
                    <p class="text-green-100 mb-6">¿Tienen un grupo? Regístrate ahora</p>
                    <a href="https://wa.me/34642158162?text=Hola,%20me%20gustaria%20obtener%20informacion%20para%20unirme%20a%20la%20comunidad%20deportazo." class="inline-flex bg-white p-2 border border-gray-300 rounded text-gray-900 items-center hover:bg-gray-200 font-medium">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Último Torneo Section -->
    <section id="torneo" class="py-20 bg-gradient-to-br from-slate-900 to-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Último Torneo</h2>
                <p class="text-xl text-slate-300">Tabla de posiciones de los grupos participantes</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-white/20 bg-white/5">
                                <th class="px-6 py-4 text-left font-semibold">Posición</th>
                                <th class="px-6 py-4 text-left font-semibold">Equipo</th>
                                <th class="px-6 py-4 text-center font-semibold">PJ</th>
                                <th class="px-6 py-4 text-center font-semibold">G</th>
                                <th class="px-6 py-4 text-center font-semibold">P</th>
                                <th class="px-6 py-4 text-center font-semibold">AF</th>
                                <th class="px-6 py-4 text-center font-semibold">AC</th>
                                <th class="px-6 py-4 text-center font-semibold">DA</th>
                                <th class="px-6 py-4 text-center font-semibold">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-yellow-400">1</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="./dist/assets/img/logo2.png" alt="Corazón Latino" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold">Corazón Latino</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">12</td>
                                <td class="px-6 py-4 text-center text-green-400">10</td>
                                <td class="px-6 py-4 text-center text-red-400">2</td>
                                <td class="px-6 py-4 text-center text-blue-400">180</td>
                                <td class="px-6 py-4 text-center text-red-400">135</td>
                                <td class="px-6 py-4 text-center text-blue-400">+45</td>
                                <td class="px-6 py-4 text-center font-bold text-lg">30</td>
                            </tr>
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-yellow-400">2</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="./dist/assets/img/logo2.png" alt="Latin Force" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold">Latin Force</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">12</td>
                                <td class="px-6 py-4 text-center text-green-400">8</td>
                                <td class="px-6 py-4 text-center text-red-400">4</td>
                                <td class="px-6 py-4 text-center text-blue-400">165</td>
                                <td class="px-6 py-4 text-center text-red-400">137</td>
                                <td class="px-6 py-4 text-center text-blue-400">+28</td>
                                <td class="px-6 py-4 text-center font-bold text-lg">24</td>
                            </tr>
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-yellow-400">3</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="./dist/assets/img/logo2.png" alt="Volley Masters" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold">Volley Masters</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">12</td>
                                <td class="px-6 py-4 text-center text-green-400">7</td>
                                <td class="px-6 py-4 text-center text-red-400">5</td>
                                <td class="px-6 py-4 text-center text-blue-400">145</td>
                                <td class="px-6 py-4 text-center text-red-400">157</td>
                                <td class="px-6 py-4 text-center text-red-400">-12</td>
                                <td class="px-6 py-4 text-center font-bold text-lg">21</td>
                            </tr>
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-yellow-400">4</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="./dist/assets/img/logo2.png" alt="Beach Warriors" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold">Beach Warriors</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">12</td>
                                <td class="px-6 py-4 text-center text-green-400">6</td>
                                <td class="px-6 py-4 text-center text-red-400">6</td>
                                <td class="px-6 py-4 text-center text-blue-400">140</td>
                                <td class="px-6 py-4 text-center text-red-400">158</td>
                                <td class="px-6 py-4 text-center text-red-400">-18</td>
                                <td class="px-6 py-4 text-center font-bold text-lg">18</td>
                            </tr>
                            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-center font-bold text-yellow-400">5</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="./dist/assets/img/logo2.png" alt="Spike Attack" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold">Spike Attack</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">12</td>
                                <td class="px-6 py-4 text-center text-green-400">4</td>
                                <td class="px-6 py-4 text-center text-red-400">8</td>
                                <td class="px-6 py-4 text-center text-blue-400">125</td>
                                <td class="px-6 py-4 text-center text-red-400">168</td>
                                <td class="px-6 py-4 text-center text-red-400">-43</td>
                                <td class="px-6 py-4 text-center font-bold text-lg">12</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-white/5 border-t border-white/20 text-right">
                    <a href="#grupos" class="inline-flex items-center text-yellow-400 hover:text-yellow-300 font-semibold transition-colors">
                        Ver más torneos
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Siguiente Fase -->
            <div class="mt-16">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-white mb-4">Siguiente Fase</h3>
                    <p class="text-lg text-slate-300">Árbol de Eliminatorias</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 relative overflow-hidden">
                    <!-- Árbol de Eliminatorias -->
                    <div class="relative min-h-[400px]">

                        <!-- Semifinal - Nivel inferior -->
                        <div class="flex justify-between items-end mb-16 relative">
                            <!-- Equipo 2 (Latin Force) -->
                            <div class="flex flex-col items-center gap-4 w-1/3">
                                <div class="bg-white/10 rounded-lg p-4 w-full max-w-[200px] border border-slate-600">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="./dist/assets/img/logo2.png" alt="Latin Force" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold text-white">Latin Force</span>
                                    </div>
                                    <div class="text-sm text-slate-300">2do lugar - 24 pts</div>
                                </div>
                                <!-- Línea horizontal hacia el centro -->
                                <div class="w-full h-0.5 bg-yellow-400 relative">
                                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Espacio central para semifinal -->
                            <div class="w-1/3 flex justify-center">
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg p-4 min-w-[200px] border-2 border-yellow-400 shadow-lg">
                                    <div class="text-center">
                                        <i class="fas fa-trophy text-yellow-400 text-xl mb-2"></i>
                                        <div class="text-white font-semibold text-sm">Semifinal</div>
                                        <div class="text-yellow-100 text-xs">Ganador</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipo 3 (Volley Masters) -->
                            <div class="flex flex-col items-center gap-4 w-1/3">
                                <!-- Línea horizontal desde el centro -->
                                <div class="w-full h-0.5 bg-yellow-400 relative">
                                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                                <div class="bg-white/10 rounded-lg p-4 w-full max-w-[200px] border border-slate-600">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="./dist/assets/img/logo2.png" alt="Volley Masters" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold text-white">Volley Masters</span>
                                    </div>
                                    <div class="text-sm text-slate-300">3er lugar - 21 pts</div>
                                </div>
                            </div>
                        </div>

                        <!-- Línea vertical conectando semifinal con final -->
                        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-0.5 h-16 bg-yellow-400"></div>

                        <!-- Final - Nivel superior -->
                        <div class="flex justify-center items-start relative">
                            <!-- Equipo 1 (Corazón Latino) -->
                            <div class="flex flex-col items-center gap-4 mr-8">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg p-4 min-w-[200px] border-2 border-blue-400 shadow-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <img src="./dist/assets/img/logo2.png" alt="Corazón Latino" class="w-8 h-8 rounded object-cover">
                                        <span class="font-semibold text-white">Corazón Latino</span>
                                    </div>
                                    <div class="text-blue-100 text-sm">1er lugar - 30 pts</div>
                                </div>
                                <!-- Línea horizontal hacia la final -->
                                <div class="w-16 h-0.5 bg-blue-400 relative">
                                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-blue-400 rounded-full"></div>
                                </div>
                            </div>

                            <!-- VS -->
                            <div class="flex flex-col items-center justify-center mx-4">
                                <div class="text-blue-400 text-2xl font-bold mb-2">VS</div>
                                <div class="text-slate-400 text-sm">Final</div>
                            </div>

                            <!-- Ganador Semifinal -->
                            <div class="flex flex-col items-center gap-4 ml-8">
                                <!-- Línea horizontal desde la semifinal -->
                                <div class="w-16 h-0.5 bg-yellow-400 relative">
                                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-yellow-400 rounded-full"></div>
                                </div>
                                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg p-4 min-w-[200px] border-2 border-yellow-400 shadow-lg">
                                    <div class="text-center">
                                        <i class="fas fa-trophy text-yellow-400 text-xl mb-2"></i>
                                        <div class="text-white font-semibold text-sm">Ganador</div>
                                        <div class="text-yellow-100 text-xs">Semifinal</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campeón -->
                        <div class="flex justify-center mt-12">
                            <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg p-6 min-w-[250px] border-2 border-purple-400 shadow-2xl">
                                <div class="text-center">
                                    <i class="fas fa-crown text-yellow-400 text-3xl mb-3"></i>
                                    <div class="text-white font-bold text-lg">Campeón del Torneo</div>
                                    <div class="text-purple-200 text-sm mt-1">Ganador de la Final</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto Section -->
    <section id="contacto" class="py-20 bg-gradient-to-br from-slate-800 to-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Contacto</h2>
                <p class="text-xl text-slate-300">Conecta con la comunidad del voleibol de Madrid</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Información de Contacto -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-2xl font-semibold text-white mb-6">Información de Contacto</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="bg-blue-500 p-3 rounded-lg">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Ubicación</h4>
                                    <p class="text-slate-300">Madrid, España</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="bg-green-500 p-3 rounded-lg">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Email</h4>
                                    <p class="text-slate-300">info@deportazo.com</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="bg-purple-500 p-3 rounded-lg">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium">Teléfono</h4>
                                    <p class="text-slate-300">+34 600 000 000</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div>
                        <h3 class="text-2xl font-semibold text-white mb-6">Síguenos</h3>
                        <div class="flex gap-4">
                            <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-lg transition-colors">
                                <i class="fab fa-facebook-f text-blue-400 text-xl"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-lg transition-colors">
                                <i class="fab fa-instagram text-pink-400 text-xl"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-lg transition-colors">
                                <i class="fab fa-twitter text-blue-300 text-xl"></i>
                            </a>
                            <a href="#" class="bg-white/10 hover:bg-white/20 p-3 rounded-lg transition-colors">
                                <i class="fab fa-youtube text-red-400 text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Contacto -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8">
                    <h3 class="text-2xl font-semibold text-white mb-6">Envíanos un Mensaje</h3>
                    <form class="space-y-6">
                        <div >
                                <label class="block text-sm font-medium text-slate-300 mb-2">Nombre</label>
                                <input type="text" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tu nombre">
                            
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Asunto</label>
                            <input type="text" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Asunto del mensaje">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Mensaje</label>
                            <textarea rows="4" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Tu mensaje..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                            Enviar Mensaje
                        </button>
                    </form>
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
                        <li><i class="fas fa-envelope mr-2"></i>jlverbel09.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Madrid, España</li>
                        <li><i class="fas fa-phone mr-2"></i>+34 642 15 81 62</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2026 Deportazo. Todos los derechos reservados. Desarrollado por GeorkingWeb</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="./dist/js/login.js"></script>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/34642158162?text=Hola,%20me%20gustaría%20información%20sobre%20Deportazo"
       target="_blank"
       class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110 z-50 group">
        <i class="fab fa-whatsapp text-2xl"></i>
        <span class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-1 rounded-lg text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            ¡Contáctanos por WhatsApp!
        </span>
    </a>

</body>
</html>