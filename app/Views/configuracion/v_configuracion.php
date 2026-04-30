<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30">

    <?= view('plantillas/p_menu.php') ?>

    <!-- === Contenedor Principal === -->
    <main class="max-w-4xl mx-auto mt-10 px-4">
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Configuración</h1>
            <p class="text-purple-100 mt-2 font-medium">Personaliza tu experiencia y gestiona tu cuenta.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- === Sección: Información de la Aplicación === -->
            <section class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 p-8 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-purple-500/20 rounded-lg">
                        <svg class="w-6 h-6 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Sobre Lintian Wallet</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-purple-200 text-sm font-semibold uppercase tracking-wider mb-2">Creadores</h3>
                        <p class="text-white font-medium">Lierni Sarraoa y el equipo de desarrollo de Lintian.</p>
                        <p class="text-purple-100/70 text-sm mt-1">Pasión por las finanzas y la tecnología moderna.</p>
                    </div>

                    <div>
                        <h3 class="text-purple-200 text-sm font-semibold uppercase tracking-wider mb-2">Nuestros Clientes</h3>
                        <p class="text-white font-medium">+5,000 usuarios activos</p>
                        <p class="text-purple-100/70 text-sm mt-1">Esta aplicación está desarrollada exclusivamente para el uso de los clientes de Banco Hispania.</p>
                    </div>

                    <div class="pt-4 border-t border-white/10">
                        <p class="text-purple-100/50 text-xs">Versión 1.2.0 - © 2026 Lintian Corp.</p>
                    </div>
                </div>
            </section>

            <!-- === Sección: Ajustes de Cuenta === -->
            <section class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 p-8 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <img src="<?= base_url('usuario/foto/' . session()->get('dni')) ?>" 
                             alt="Perfil" 
                             class="relative h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-200">
                    </div>
                    <h2 class="text-xl font-bold text-white">Tu Cuenta</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-purple-200 text-sm font-semibold uppercase tracking-wider mb-2">Cambiar Contraseña</label>
                        
                        <!-- Mensajes de Error/Éxito -->
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="mb-4 p-3 bg-emerald-500/20 border border-emerald-500/50 rounded-xl text-emerald-200 text-sm">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm">
                                <ul class="list-disc list-inside">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('configuracion/cambiarContrasenia') ?>" method="POST" class="space-y-3">
                            <input type="password" name="old_password" placeholder="Contraseña actual" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-purple-500/50 transition-all">
                            <input type="password" name="new_password" placeholder="Nueva contraseña" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-purple-500/50 transition-all">
                            <button type="submit" class="w-full py-2 bg-purple-600 hover:bg-purple-500 text-white font-bold rounded-xl shadow-lg transition-all transform hover:scale-[1.02] active:scale-95">
                                Actualizar Contraseña
                            </button>
                        </form>
                    </div>

                    <div>
                        <label class="block text-purple-200 text-sm font-semibold uppercase tracking-wider mb-2">Preferencia de Idioma</label>
                        <div class="relative lang-dropdown-container">
                            <button onclick="toggleLangMenu(this)" class="w-full flex items-center justify-between gap-2 px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white transition-all cursor-pointer hover:bg-white/10">
                                <div class="flex items-center gap-3">
                                    <img class="lang-display-flag w-6 h-auto rounded-sm" src="https://flagcdn.com/w20/es.png" alt="flag">
                                    <span class="lang-display-text font-medium">Español</span>
                                </div>
                                <svg class="w-4 h-4 text-white/50 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Hidden Select for compatibility -->
                            <select id="selectIdioma" class="hidden">
                                <option value="es">Español</option>
                                <option value="eu">Euskara</option>
                                <option value="en">English</option>
                                <option value="fr">Français</option>
                                <option value="pt">Português</option>
                                <option value="it">Italiano</option>
                                <option value="zh-TW">Chino</option>
                                <option value="ja">Japonés</option>
                            </select>
                            <!-- Dropdown Menu -->
                            <div class="lang-dropdown-menu hidden absolute left-0 right-0 bottom-full mb-2 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 transition-all">
                                <button onclick="cambiarIdioma('es')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/es.png" class="w-5 h-auto rounded-sm" alt="ES"> Español
                                </button>
                                <button onclick="cambiarIdioma('eu')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="<?= base_url('img/flags/euskara.jpg') ?>" class="w-5 h-auto rounded-sm" alt="EU"> Euskara
                                </button>
                                <button onclick="cambiarIdioma('en')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm" alt="EN"> English
                                </button>
                                <button onclick="cambiarIdioma('fr')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/fr.png" class="w-5 h-auto rounded-sm" alt="FR"> Français
                                </button>
                                <button onclick="cambiarIdioma('pt')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/pt.png" class="w-5 h-auto rounded-sm" alt="PT"> Português
                                </button>
                                <button onclick="cambiarIdioma('it')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/it.png" class="w-5 h-auto rounded-sm" alt="IT"> Italiano
                                </button>
                                <button onclick="cambiarIdioma('zh-TW')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/tw.png" class="w-5 h-auto rounded-sm" alt="ZH"> Chino
                                </button>
                                <button onclick="cambiarIdioma('ja')" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                    <img src="https://flagcdn.com/w20/jp.png" class="w-5 h-auto rounded-sm border border-gray-200 shadow-sm" alt="JA"> Japonés
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- === Sección: Sesión (Ancho Completo) === -->
            <section class="md:col-span-2 bg-red-500/10 backdrop-blur-md rounded-3xl border border-red-500/20 p-8 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-xl font-bold text-white">Gestión de Sesión</h2>
                    <p class="text-red-200/70 mt-1">Si has terminado de gestionar tus finanzas, te recomendamos cerrar la sesión.</p>
                </div>
                <button onclick="window.location.href='<?= base_url('logout') ?>'" class="flex items-center gap-2 px-8 py-4 bg-red-600 hover:bg-red-500 text-white font-bold rounded-2xl shadow-lg transition-all transform hover:scale-105 active:scale-95 border border-red-400/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar Sesión
                </button>
            </section>
        </div>
    </main>

</body>

</html>
