<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="tituloNuevoGasto"><?= tr('tituloNuevoGasto') ?? 'Nuevo Gasto' ?></title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#ef4444]/30 flex flex-col">
    <?= view('plantillas/p_menu.php') ?>

    <!-- === Contenedor Principal: Centrado absoluto en toda la página === -->
    <main class="flex-grow flex items-center justify-center px-4 py-16 md:py-24">
        <div class="w-full max-w-lg bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden transform transition-all">
            <div class="p-8 md:p-10">
                <div class="mb-8 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-white tracking-tight" data-tr="tituloNuevoGasto"><?= tr("tituloNuevoGasto") ?? 'Nuevo Gasto' ?></h1>
                    <p class="text-purple-200 font-medium" data-tr="descNuevoGasto"><?= tr("descNuevoGasto") ?? 'Registra una salida de dinero en la cuenta seleccionada.' ?></p>
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

                <!-- FORMULARIO: Envia los datos al método crear del controlador C_Gasto -->
                <?= form_open('gastos/crear', ['class' => 'space-y-6']) ?>
                <!-- Hidden inputs -->
                <input type="hidden" name="id_cuenta" value="<?= esc($id_cuenta ?? '') ?>">

                <!-- Dinero a gastar -->
                <div class="space-y-2 group">
                    <label for="dinero" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#ef4444] transition-colors"><span data-tr="labelCantidadGasto"><?= tr("labelCantidadGasto") ?? 'Cantidad a gastar (€)' ?></span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-white/50 font-bold">€</span>
                        </div>
                        <input type="number" step="0.01" name="dinero" id="dinero" required
                            class="w-full pl-10 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-[#ef4444]/50 focus:border-[#ef4444] transition-all text-lg font-medium"
                            placeholder="<?= tr('placeholderDinero') ?? '0,00' ?>" data-tr="placeholderDinero">
                    </div>
                </div>

                <!-- Fecha de gasto -->
                <div class="space-y-2 group">
                    <label for="fecha" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#ef4444] transition-colors"><span data-tr="labelFechaGasto"><?= tr("labelFechaGasto") ?? 'Fecha del Gasto' ?></span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <!-- Inicializamos el valor predeterminado como fecha de hoy -->
                        <input type="date" name="fecha" id="fecha" required value="<?= date('Y-m-d') ?>"
                            class="w-full pl-11 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-[#ef4444]/50 focus:border-[#ef4444] transition-all text-lg font-medium [color-scheme:dark]">
                    </div>
                </div>

                <!-- Selector de Subcategoría (ej. Comida, Ocio...) sacada de base de datos -->
                <!-- Subcategoría -->
                <div class="space-y-2 group">
                    <label for="id_subcategoria" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#ef4444] transition-colors"><span data-tr="labelSubcategoria"><?= tr("labelSubcategoria") ?? 'Subcategoría del Gasto' ?></span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <select name="id_subcategoria" id="id_subcategoria" required
                            onchange="toggleOtroSubcategoria(this)"
                            class="w-full pl-11 pr-10 py-4 bg-white/10 border border-white/20 rounded-2xl text-white appearance-none focus:outline-none focus:ring-2 focus:ring-[#ef4444]/50 focus:border-[#ef4444] transition-all font-medium cursor-pointer">
                            <option value="" disabled selected class="bg-purple-800 text-white" data-tr="opcionSeleccionaCategoria"><?= tr("opcionSeleccionaCategoria") ?? 'Selecciona una subcategoría' ?></option>
                            <?php if(!empty($subcategorias)): ?>
                                <?php foreach ($subcategorias as $sub): ?>
                                    <option value="<?= esc($sub->id) ?>" class="bg-purple-800 text-white">
                                        <?= esc($sub->nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <option value="otro" class="bg-purple-800 text-white" data-tr="opcionOtraCategoria"><?= tr("opcionOtraCategoria") ?? 'Otro...' ?></option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Campo de texto que aparece solo si elige 'Otro' -->
                    <div id="wrapper_nueva_subcategoria" class="hidden mt-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-yellow-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <input type="text" name="nueva_subcategoria" id="nueva_subcategoria"
                                placeholder="<?= tr('placeholderNuevaSubcategoria') ?? 'Nombre de la nueva subcategoría...' ?>" data-tr="placeholderNuevaSubcategoria"
                                class="w-full pl-11 pr-4 py-3 bg-yellow-400/10 border border-yellow-400/40 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all font-medium">
                        </div>
                        <p class="text-yellow-300/70 text-xs mt-1.5 ml-1" data-tr="descNuevaSubcategoria"><?= tr('descNuevaSubcategoria') ?? 'Se creará automáticamente una nueva subcategoría con ese nombre.' ?></p>
                    </div>
                </div>

                <!-- Zona inferor de confirmación o cancelar -->
                <!-- Botones de Acción -->
                <div class="flex flex-col gap-4 pt-4">
                    <button type="submit" data-tr="btnAnadirGasto"
                        class="w-full py-4 bg-[#ef4444] hover:bg-[#dc2626] text-white font-bold rounded-2xl shadow-xl shadow-[#ef4444]/20 transition-all transform hover:-translate-y-1 active:scale-95 text-lg">
                        <?= tr("btnAnadirGasto") ?? 'Añadir Gasto' ?>
                    </button>
                    <!-- El botón volver usa javascript para ir a la cuenta concreta o base_url('gastos') -->
                    <a href="<?= base_url('gastos?cuenta_id=' . esc($id_cuenta ?? '')) ?>" data-tr="btnVolver"
                        class="w-full py-4 bg-white/5 hover:bg-white/10 text-white font-bold rounded-2xl border border-white/10 transition-all text-center text-lg">
                        <?= tr("btnVolver") ?? 'Volver' ?>
                    </a>
                </div>
                <?= form_close() ?>
            </div>

            <!-- Estética Inferior -->
            <div class="px-8 py-4 bg-black/20 border-t border-white/10 flex justify-between items-center">
                <span class="text-xs font-bold text-white/30 tracking-widest uppercase" data-tr="seguridadProtocolo"><?= tr("seguridadProtocolo") ?? 'Lintian Security Protocol' ?></span>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#ef4444]"></div>
                    <div class="w-2 h-2 rounded-full bg-[#ef4444]/30"></div>
                </div>
            </div>
        </div>
    </main>

<script>
    function toggleOtroSubcategoria(select) {
        const wrapper = document.getElementById('wrapper_nueva_subcategoria');
        const input   = document.getElementById('nueva_subcategoria');
        if (select.value === 'otro') {
            wrapper.classList.remove('hidden');
            input.required = true;
            input.focus();
        } else {
            wrapper.classList.add('hidden');
            input.required = false;
            input.value = '';
        }
    }
</script>
</body>

</html>
