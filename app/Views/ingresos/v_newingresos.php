<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ingreso | Lintian Wallet</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30 flex flex-col">
    <?= view('plantillas/p_menu.php') ?>

    <main class="flex-grow flex items-center justify-center px-4 py-16 md:py-24">
        <div class="w-full max-w-lg bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden transform transition-all">
            <div class="p-8 md:p-10">
                <div class="mb-8 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Nuevo Ingreso</h1>
                    <p class="text-purple-200 font-medium">Registra una entrada de dinero en la cuenta seleccionada.</p>
                </div>

                <!-- Errores de validación -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="w-full bg-red-500/20 border-l-4 border-red-500 text-white p-4 rounded-r-2xl backdrop-blur-md shadow-sm mb-8" role="alert">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <ul class="list-disc list-inside text-sm font-medium">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?= form_open('ingresos/crear', ['class' => 'space-y-6']) ?>
                <!-- Hidden inputs -->
                <input type="hidden" name="id_cuenta" value="<?= esc($id_cuenta) ?>">

                <!-- Dinero a ingresar -->
                <div class="space-y-2 group">
                    <label for="dinero" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#29C6AD] transition-colors">Cantidad a ingresar (€)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-white/50 font-bold">€</span>
                        </div>
                        <input type="number" step="0.01" name="dinero" id="dinero" required
                            class="w-full pl-10 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all text-lg font-medium"
                            placeholder="0,00">
                    </div>
                </div>

                <!-- Fecha de ingreso -->
                <div class="space-y-2 group">
                    <label for="fecha" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#29C6AD] transition-colors">Fecha de Ingreso</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <!-- Inicializamos el valor predeterminado como fecha de hoy -->
                        <input type="date" name="fecha" id="fecha" required value="<?= date('Y-m-d') ?>"
                            class="w-full pl-11 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all text-lg font-medium [color-scheme:dark]">
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col gap-4 pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-[#29C6AD] hover:bg-[#23a893] text-white font-bold rounded-2xl shadow-xl shadow-[#29C6AD]/20 transition-all transform hover:-translate-y-1 active:scale-95 text-lg">
                        Añadir Ingreso
                    </button>
                    <!-- El botón volver usa javascript para ir a la cuenta concreta o base_url('ingresos') -->
                    <a href="<?= base_url('ingresos?cuenta_id=' . esc($id_cuenta)) ?>"
                        class="w-full py-4 bg-white/5 hover:bg-white/10 text-white font-bold rounded-2xl border border-white/10 transition-all text-center text-lg">
                        Volver
                    </a>
                </div>
                <?= form_close() ?>
            </div>

            <!-- Estética Inferior -->
            <div class="px-8 py-4 bg-black/20 border-t border-white/10 flex justify-between items-center">
                <span class="text-xs font-bold text-white/30 tracking-widest uppercase">Lintian Security Protocol</span>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#29C6AD]"></div>
                    <div class="w-2 h-2 rounded-full bg-[#29C6AD]/30"></div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
