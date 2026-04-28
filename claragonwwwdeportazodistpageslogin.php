<?php
$grupo = $_GET['grupo'] ?? null;

$dataGrupo = [
    'latinforce' => [
        'nombre' => 'Latin Force',
        'logo' => 'latinforce.png',
        'slogan' => 'Pasión por el voleibol en el corazón de Madrid: aquí cada set se juega como una final.',
        'ubicacion_logo' => '../../dist/assets/img/grupos/latinforce2.jpg',
        'carrusel' => [
            '../assets/img/portadas/8.jpg',
            '../assets/img/portadas/7.jpg',
            '../assets/img/portadas/6.jpg',
            '../assets/img/portadas/5.jpg',
        ],
        'colores' => [
            'fondo' => '#000000',
            'primario' => '#b40202',
            'secundario' => '#ffffff',
            'terciario' => '#ffffff82'
        ],
        'logodeportazo' => 'logo_rojo.png'
    ],
    'corazonlatino' => [
        'nombre' => 'Corazón Latino',
        'logo' => 'corazonlatino.png',
        'slogan' => 'Pasión por el voleibol en el corazón de Madrid: aquí cada set se juega como una final.',
        'ubicacion_logo' => '../../dist/assets/img/grupos/corazonlatino.png',
        'carrusel' => [
            '../assets/img/portadas/4.jpg',
            '../assets/img/portadas/2.jpg',
            '../assets/img/portadas/3.jpg',
            '../assets/img/galeria/847f24d2-67aa-47fc-bb99-f13fa11193e4.jpeg',
        ],
        'colores' => [
            'fondo' => '#000000',
            'primario' => '#0d6efd',
            'secundario' => '#ffffff',
            'terciario' => '#0d6efd'
        ]
    ]
]
?>
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - <?= $dataGrupo[$grupo]['nombre'] ?? 'Deportazo' ?></title>
    <link rel="icon" href="https://deportazo.com/<?= $grupo ?>/dist/assets/img/grupos/<?= $dataGrupo[$grupo]['logo'] ?? 'logo2.png' ?>" type="image/x-icon">
    <meta name="theme-color" content="#0f172a">
    <meta name="description" content="<?= $dataGrupo[$grupo]['slogan'] ?? 'Pasión por el voleibol en el corazón de Madrid: aquí cada set se juega como una final.' ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#0f172a',
                        accent: '#fbbf24',
                        accent2: '#2563eb'
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            color: #f8fafc;
        }
        .login-bg {
            background-image: linear-gradient(180deg, rgba(15,23,42,0.95) 0%, rgba(15,23,42,0.55) 45%, rgba(15,23,42,0.95) 100%), url(<?= $dataGrupo[$grupo]['carrusel'][0] ?? '../assets/img/portadas/8.jpg' ?>);
            background-size: cover;
            background-position: center;
        }
        .login-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url(<?= $dataGrupo[$grupo]['carrusel'][1] ?? '../assets/img/portadas/7.jpg' ?>) center/cover no-repeat;
            opacity: 0.18;
            mix-blend-mode: screen;
        }
        .form-glow {
            box-shadow: 0 40px 120px rgba(15,23,42,0.35);
            backdrop-filter: blur(20px);
        }
        .btn-glow {
            box-shadow: 0 20px 80px rgba(251,191,36,0.28);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(251,191,36,0.3);
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="login-bg login-overlay relative min-h-screen flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/30 to-slate-950/95"></div>

        <div class="relative w-full max-w-md px-6">
            <!-- Logo Section -->
            <div class="text-center mb-8">
                <img src="<?= $dataGrupo[$grupo]['ubicacion_logo'] ?? '../../dist/assets/img/logo.png' ?>"
                     alt="<?= $dataGrupo[$grupo]['nombre'] ?? 'Deportazo' ?>"
                     class="w-24 h-24 mx-auto rounded-full border-4 border-white/20 p-1 bg-white/5 mb-4">
                <h1 class="text-2xl font-bold text-white mb-2">
                    <?= $dataGrupo[$grupo]['nombre'] ?? 'Deportazo' ?>
                </h1>
                <p class="text-slate-300 text-sm">
                    <?= $dataGrupo[$grupo]['slogan'] ?? 'Pasión por el voleibol en el corazón de Madrid' ?>
                </p>
            </div>

            <!-- Login Form -->
            <div class="form-glow bg-white/10 backdrop-blur-xl rounded-2xl p-8 border border-white/20">
                <form id="loginForm" class="space-y-6">
                    <div>
                        <label for="user" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-user mr-2"></i>Usuario
                        </label>
                        <input type="text"
                               id="user"
                               name="user"
                               class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-400 transition"
                               placeholder="Ingresa tu usuario"
                               required
                               autofocus>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                            <i class="fas fa-lock mr-2"></i>Contraseña
                        </label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:border-yellow-400 transition"
                               placeholder="Ingresa tu contraseña"
                               required>
                    </div>

                    <button type="button"
                            onclick="ingresar()"
                            class="btn-glow w-full bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-slate-950 font-semibold py-3 px-6 rounded-xl transition duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Additional Links -->
                <div class="mt-6 text-center space-y-3">
                    <a href="../../index" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition">
                        <i class="fas fa-home"></i>
                        Volver al inicio
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-slate-400 text-sm">
                    © 2024 Deportazo. Todos los derechos reservados.
                </p>
                <div class="flex justify-center gap-4 mt-4">
                    <a href="https://www.tiktok.com/@corazon__latino" target="_blank"
                       class="text-slate-400 hover:text-white transition">
                        <i class="fab fa-tiktok text-xl"></i>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-white transition">
                        <i class="fas fa-volleyball-ball text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script>
        function ingresar() {
            const user = $('#user').val().trim();
            const password = $('#password').val();

            if (!user || !password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    text: 'Por favor, ingresa tu usuario y contraseña.',
                    background: '#1e293b',
                    color: '#f8fafc'
                });
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Iniciando sesión...',
                allowOutsideClick: false,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#f8fafc',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "POST",
                url: './services/login.php?accion=iniciarSesion',
                data: { user: user, password: password },
                dataType: "json",
                success: function (respuesta) {
                    Swal.close();

                    if (respuesta.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Bienvenido!',
                            text: 'Inicio de sesión exitoso.',
                            background: '#1e293b',
                            color: '#f8fafc',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.href = 'index';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: respuesta.response || 'Usuario o contraseña incorrectos.',
                            background: '#1e293b',
                            color: '#f8fafc'
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'No se pudo conectar al servidor. Inténtalo de nuevo.',
                        background: '#1e293b',
                        color: '#f8fafc'
                    });
                }
            });
        }

        // Enter key support
        $('#user, #password').on('keypress', function(e) {
            if (e.which === 13) {
                ingresar();
            }
        });
    </script>
</body>
</html>
