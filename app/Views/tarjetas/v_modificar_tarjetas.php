<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cuenta</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30 flex flex-col">
    <?= view('plantillas/p_menu.php') ?>

    <!-- === Contenedor Principal Centrado === -->
    <main class="flex-grow flex items-center justify-center px-4 py-16 md:py-24">
        <div class="w-full max-w-lg bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 shadow-2xl overflow-hidden transform transition-all">
            <div class="p-8 md:p-10">
                <div class="mb-8 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-white tracking-tight" data-tr="tituloModificarCuenta"><?= tr('tituloModificarCuenta') ?? 'Modificar Cuenta' ?></h1>
                    <p class="text-purple-200 font-medium" data-tr="descModificarCuenta"><?= tr('descModificarCuenta') ?? 'Modifica los datos de tu tarjeta de ahorro.' ?></p>
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

                <!-- Mensaje de éxito -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="w-full bg-[#29C6AD]/20 border-l-4 border-[#29C6AD] text-white p-4 rounded-r-2xl backdrop-blur-md shadow-sm mb-8" role="alert">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-[#29C6AD] mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium">
                                <?= esc(session()->getFlashdata('success')) ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Ajusta la ruta 'tarjetas/actualizar' según tengas en tu controlador y rutas -->
                <!-- FORMULARIO DINÁMICO: Envía los cambios de la tarjeta apuntando específicamente a su ID -->
                <?= form_open('tarjetas/modificar/' . (isset($cuenta->id) ? esc($cuenta->id) : esc($cuenta['id'] ?? '')), ['class' => 'space-y-6']) ?>

                <!-- Saldo Inicial -->
                <div class="space-y-2 group">
                    <label for="saldoTotal" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#29C6AD] transition-colors" data-tr="labelSaldoInicial"><?= tr('labelSaldoInicial') ?? 'Saldo Inicial (€)' ?></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-white/50 font-bold">€</span>
                        </div>
                        <?php
                        $saldoActual = isset($cuenta->saldoTotal) ? $cuenta->saldoTotal : (isset($cuenta['saldoTotal']) ? $cuenta['saldoTotal'] : '');
                        ?>
                        <input type="number" step="0.01" name="saldoTotal" id="saldoTotal" required
                            class="w-full pl-10 pr-4 py-4 bg-white/10 border border-white/20 rounded-2xl text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all text-lg font-medium"
                            placeholder="<?= tr('placeholderSaldo') ?? '0,00' ?>" data-tr="placeholderSaldo" value="<?= esc($saldoActual) ?>">
                    </div>
                </div>

                <!-- Categoría Autoseleccionada: Se marca por defecto la categoría que ya tenía la tarjeta -->
                <!-- Categoría -->
                <div class="space-y-2 group">
                    <label for="id_categoria" class="text-sm font-semibold text-purple-100 ml-1 group-focus-within:text-[#29C6AD] transition-colors" data-tr="labelCategoriaCuenta"><?= tr('labelCategoriaCuenta') ?? 'Categoría de la Cuenta' ?></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <select name="id_categoria" id="id_categoria" required
                            class="w-full pl-11 pr-10 py-4 bg-white/10 border border-white/20 rounded-2xl text-white appearance-none focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all font-medium cursor-pointer">
                            <option value="" disabled class="bg-purple-800 text-white" data-tr="opcionSeleccionCategoria"><?= tr('opcionSeleccionCategoria') ?? 'Selecciona una categoría' ?></option>
                            <?php
                            $idCatActual = isset($cuenta->id_categoria) ? $cuenta->id_categoria : (isset($cuenta['id_categoria']) ? $cuenta['id_categoria'] : '');
                            ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria->id ?>" <?= $categoria->id == $idCatActual ? 'selected' : '' ?> class="bg-purple-800 text-white">
                                    <?= esc($categoria->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <?php if (isset($usuario)): ?>
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?= esc($usuario->dni ?? '') ?>">
                <?php endif; ?>

                <!-- Botones de Guardar y Confirmar, o Volver atrás -->
                <!-- Botones de Acción -->
                <div class="flex flex-col gap-4 pt-4">
                    <button type="submit" data-tr="btnGuardarCambios"
                        class="w-full py-4 bg-[#29C6AD] hover:bg-[#23a893] text-white font-bold rounded-2xl shadow-xl shadow-[#29C6AD]/20 transition-all transform hover:-translate-y-1 active:scale-95 text-lg">
                        <?= tr('btnGuardarCambios') ?? 'Guardar Cambios' ?>
                    </button>
                    <a href="<?= base_url('tarjetas') ?>" data-tr="btnCancelar"
                        class="w-full py-4 bg-white/5 hover:bg-white/10 text-white font-bold rounded-2xl border border-white/10 transition-all text-center text-lg">
                        <?= tr('btnCancelar') ?? 'Cancelar' ?>
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