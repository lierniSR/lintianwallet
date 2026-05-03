<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="menuCuentas"><?= tr('menuCuentas') ?? 'Cuentas' ?> | Lintian Wallet</title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30">

    <?= view('plantillas/p_menu.php') ?>

    <!-- === Vista de Cuentas: Gestión de tarjetas y balance total === -->
    <main class="max-w-7xl mx-auto mt-10 px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div class="flex items-center gap-4">
                <?php if (session()->get('dni')): ?>
                    <!-- Avatar del usuario con efecto de brillo -->
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-25 group-hover:opacity-40 transition duration-300"></div>
                        <img src="<?= base_url('usuario/foto/' . session()->get('dni')) ?>"
                            alt="Perfil"
                            class="relative h-16 w-16 rounded-full object-cover border-4 border-white shadow-xl shadow-purple-900/20">
                    </div>
                <?php endif; ?>
                <div>
                    <h1 class="text-4xl font-extrabold text-white tracking-tight"><span data-tr="bienvenidaNuevamente"><?= tr('bienvenidaNuevamente') ?? 'Bienvenido/a de nuevo' ?></span> <?= esc($usuario->nombre ?? 'Usuario') ?></h1>
                    <p class="text-purple-100 mt-2 font-medium" data-tr="tarjetasBienvenida"><?= tr("tarjetasBienvenida")  ?></p>
                </div>
            </div>

            <!-- Botón para crear una nueva cuenta/tarjeta -->
            <button onclick="window.location.href='<?= base_url('tarjetas/new') ?>'" class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span data-tr="nuevaTarjeta"><?= tr('nuevaTarjeta') ?></span>
            </button>
        </div>

        <!-- Comprobamos si el usuario tiene cuentas/tarjetas -->
        <?php if (!empty($cuentas)) : ?>
            <?php
            // Definición de gradientes premium para las tarjetas
            $gradients = [
                'from-purple-500 to-indigo-600',
                'from-blue-500 to-cyan-600',
                'from-emerald-500 to-teal-600',
                'from-rose-500 to-orange-600',
                'from-slate-700 to-slate-900',
                'from-amber-400 to-orange-500',
                'from-fuchsia-600 to-purple-600',
                'from-sky-400 to-blue-500'
            ];
            ?>
            <!-- Cuadrícula de Tarjetas: Layout responsivo -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($cuentas as $cuenta) : ?>
                    <?php
                    // Seleccionar gradiente aleatorio para cada tarjeta
                    $randomGradient = $gradients[array_rand($gradients)];
                    ?>
                    <div class="group relative h-56 rounded-3xl bg-gradient-to-br <?= $randomGradient ?> p-8 shadow-2xl hover:shadow-purple-500/20 transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-white/10">
                        <!-- Capas decorativas de la tarjeta -->
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-all duration-500"></div>
                        <div class="absolute -left-20 -bottom-20 w-48 h-48 bg-black/5 rounded-full blur-2xl"></div>

                        <div class="relative h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-white/70 text-sm font-semibold tracking-widest uppercase" data-tr="balanceTotalTarjetas"><?= tr("balanceTotalTarjetas") ?></p>
                                    <h2 class="text-3xl font-bold text-white mt-1"><?= number_format($cuenta->saldoTotal, 2, ',', '.') ?>€</h2>
                                </div>
                                <!-- Icono NFC -->
                                <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a9.5 9.5 0 0113.152 0m-15.657-5.657a13.5 13.5 0 0118.158 0" />
                                </svg>
                            </div>

                            <div class="flex items-end justify-between">
                                <div class="space-y-4">
                                    <!-- Chip de la tarjeta -->
                                    <div class="w-12 h-9 bg-gradient-to-tr from-yellow-200 to-yellow-500 rounded-lg shadow-inner flex items-center justify-center p-1.5 opacity-80 overflow-hidden">
                                        <div class="w-full h-full border border-black/20 rounded-sm grid grid-cols-2 grid-rows-3 gap-0.5">
                                            <div class="border-b border-black/10"></div>
                                            <div class="border-b border-black/10"></div>
                                            <div class="border-b border-black/10"></div>
                                            <div class="border-b border-black/10"></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <!-- Nombre de la categoría/número oculto -->
                                    <?php foreach ($categorias ?? [] as $categoria) : ?>
                                        <?php if ($categoria->id == $cuenta->id_categoria) : ?>
                                            <div class="text-xl font-bold text-white/90 tracking-wide card-number-display"
                                                data-number="<?= $categoria->nombre ?>">
                                                ••••
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Marca de la tarjeta -->
                                <div class="flex flex-col items-end">
                                    <div class="flex -space-x-4">
                                        <div class="w-10 h-10 rounded-full bg-red-500/80 backdrop-blur-sm shadow-sm border border-white/10"></div>
                                        <div class="w-10 h-10 rounded-full bg-orange-400/80 backdrop-blur-sm shadow-sm border border-white/10"></div>
                                    </div>
                                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-tighter mt-1">Lintian Platinum</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción (Overlay al hacer hover o click en móvil) -->
                        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 group-[.mobile-active]:opacity-100 transition-all duration-300 flex items-center justify-center gap-4 pointer-events-none group-hover:pointer-events-auto group-[.mobile-active]:pointer-events-auto">
                            <!-- Icono: Ojo (Ver/Ocultar Categoria) -->
                            <button title="<?= tr('titleOcultarCategoria') ?? 'Ver/Ocultar' ?>" data-tr-title="titleOcultarCategoria" class="toggle-number-btn p-3 bg-white/20 hover:bg-white/30 rounded-full text-white transition-all transform hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <!-- Icono: Movimientos (Consistent with menu) -->
                            <button title="<?= tr('menuMovimientos') ?? 'Movimientos' ?>" data-tr-title="menuMovimientos" onclick="window.location.href='<?= base_url('movimientos?cuenta_id=' . $cuenta->id) ?>'" class="p-3 bg-white/20 hover:bg-white/30 rounded-full text-white transition-all transform hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </button>
                            <!-- Icono: Engranaje (Modificar Cuenta) - Corregido y completo -->
                            <button title="<?= tr('titleModificar') ?? 'Modificar' ?>" data-tr-title="titleModificar" onclick="window.location.href='<?= base_url('tarjetas/modificar/' . $cuenta->id) ?>'" class="p-3 bg-white/20 hover:bg-white/30 rounded-full text-white transition-all transform hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <!-- Menú alternativo cuando NO hay cuentas creadas -->
        <?php if (empty($cuentas)) : ?>
            <div class="flex flex-col items-center justify-center py-20 bg-white/5 backdrop-blur-md rounded-3xl border border-white/10 shadow-xl">
                <div class="p-6 bg-white/10 rounded-full mb-6">
                    <svg class="w-16 h-16 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2" data-tr="sinCuentas"><?= tr('sinCuentas') ?? 'Aún no tienes cuentas' ?></h3>
                <p class="text-purple-200 mb-8" data-tr="descSinCuentas"><?= tr('descSinCuentas') ?? 'Comienza a ahorrar creando tu primera cuenta ahora.' ?></p>
                <button onclick="window.location.href='<?= base_url('tarjetas/new') ?>'" class="px-8 py-3 bg-[#29C6AD] hover:bg-[#23a893] text-white font-bold rounded-full shadow-lg transition-all transform hover:scale-105" data-tr="btnCrearPrimeraCuenta">
                    <?= tr('btnCrearPrimeraCuenta') ?? 'Crear mi primera cuenta' ?>
                </button>
            </div>
        <?php endif ?>
    </main>

    <!-- Lógica en JavaScript para ocultar/mostrar número de la tarjeta y animaciones en móviles -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle Card Number
            document.querySelectorAll('.toggle-number-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // Avoid triggering mobile tap reveal
                    const card = e.currentTarget.closest('.group');
                    const display = card.querySelector('.card-number-display');

                    if (display.innerHTML.trim() === '••••') {
                        display.innerHTML = display.getAttribute('data-number');
                    } else {
                        display.innerHTML = '••••';
                    }
                });
            });

            // Mobile Interactivity: Tap to Reveal Overlay
            const cards = document.querySelectorAll('.group.relative.h-56');

            cards.forEach(card => {
                card.addEventListener('click', (e) => {
                    // Check if we are on a touch device or small screen
                    if (window.innerWidth < 1024) {
                        const isActive = card.classList.contains('mobile-active');

                        // Close all other cards
                        cards.forEach(c => c.classList.remove('mobile-active'));

                        if (!isActive) {
                            card.classList.add('mobile-active');
                        }
                    }
                });
            });

            // Close card overlay when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.group')) {
                    cards.forEach(card => card.classList.remove('mobile-active'));
                }
            });
        });
    </script>
</body>