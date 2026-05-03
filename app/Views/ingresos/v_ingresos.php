<?php
// PREPROCESADO: Sumamos todo el dinero de los ingresos para tener la cifra del bloque izquierdo
// Calculamos el total de los ingresos
$totalIngresos = array_reduce($ingresos ?? [], function ($carry, $item) {
    $dinero = isset($item->dinero) ? $item->dinero : 0;
    return $carry + $dinero;
}, 0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="menuIngresos"><?= tr('menuIngresos') ?? 'Ingresos' ?> | Lintian Wallet</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30">

    <?= view('plantillas/p_menu.php') ?>

    <!-- === Vista de Ingresos: Resumen y listado de entradas de dinero === -->

    <main class="max-w-7xl mx-auto mt-10 px-4">
        <!-- === Título y Selector de Cuenta === -->
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight" data-tr="tituloIngresos"><?= tr("tituloIngresos") ?? 'Tus Ingresos' ?></h1>
                <p class="text-purple-100 mt-2 font-medium" data-tr="descripcionIngresos"><?= tr("descripcionIngresos") ?? 'Controla y visualiza todas tus entradas de dinero.' ?></p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Select de Cuentas -->
                <?php if (!empty($cuentas)): ?>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <select onchange="window.location.href='<?= base_url('ingresos') ?>?cuenta_id=' + this.value" class="appearance-none w-full md:min-w-[300px] pl-11 pr-10 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-2xl border border-white/20 text-white font-medium focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 transition-all cursor-pointer">
                            <?php foreach ($cuentas as $c): ?>
                                <!-- Mostramos ID de tarjeta como indicativo básico -->
                                <option value="<?= $c->id ?>" <?= ($c->id == ($cuenta_seleccionada ?? null)) ? 'selected' : '' ?> class="bg-purple-800 text-white">
                                    <?= esc($c->categoria_nombre ?? 'Cuenta Nº' . $c->id) ?> - <?= number_format($c->saldoTotal, 2, ',', '.') ?>€
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Botón para Registrar Nuevo Ingreso -->
                <?php if (!empty($cuenta_seleccionada)): ?>
                    <a href="<?= base_url('ingresos/new/' . esc($cuenta_seleccionada)) ?>" class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span data-tr="botonRegistrarIngreso"><?= tr("botonRegistrarIngreso") ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Divisor principal de la cuadrícula: izquierda (cifra total) y derecha (lista de ingresos) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna lateral: Gráfica / Info rápida de ingresos (simulada) -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gradient-to-br from-[#29C6AD] to-[#128a76] p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <p class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2" data-tr="totalIngresos"><?= tr("totalIngresos") ?></p>
                        <h2 class="text-4xl font-extrabold text-white mb-1">+<?= number_format($totalIngresos, 2, ',', '.') ?> €</h2>
                    </div>
                </div>
            </div>

            <!-- Columna principal: Lista de Ingresos -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden min-h-[500px]">
                    <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3 class="text-xl font-bold text-white" data-tr="ultimosMovimientos"><?= tr("ultimosMovimientos") ?></h3>
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="flex items-center gap-1.5 animate-pulse bg-green-500/20 px-3 py-1 rounded-full border border-green-500/30 mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-bold text-green-400 uppercase tracking-wide">
                                        <?= strpos(strtolower(session()->getFlashdata('success')), 'eliminad') !== false ? (tr('statusEliminado') ?? 'Eliminado') : (tr('statusIngresado') ?? 'Ingresado') ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="p-4 space-y-2">
                        <?php if (empty($ingresos)): ?>
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/5">
                                    <svg class="w-10 h-10 text-purple-300/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-white font-bold text-xl mb-1" data-tr="sinIngresos"><?= tr('sinIngresos') ?? 'No hay ingresos todavía' ?></h4>
                                <p class="text-purple-200/60 text-sm" data-tr="descSinIngresos"><?= tr('descSinIngresos') ?? 'Registra tu primer ingreso para verlo reflejado aquí.' ?></p>
                            </div>
                        <?php else: ?>
                            <!-- Bucle que escupe el HTML de cada tarjeta de ingreso individualmente -->
                            <?php foreach ($ingresos as $ingreso): ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-transparent hover:border-white/10 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-full bg-[#29C6AD]/20 text-[#29C6AD] flex items-center justify-center font-bold shadow-inner group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold text-lg leading-tight" data-tr="ingresoN"><?= tr('ingresoN') ?? 'Ingreso Nº' ?><?= esc($ingreso->id) ?></h4>
                                            <p class="text-white/50 text-sm font-medium mt-0.5">
                                                <?= date('d M Y', strtotime($ingreso->fecha)) ?> • <span class="text-purple-300">Ahorros</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <p class="text-[#29C6AD] font-bold text-xl drop-shadow-sm group-hover:drop-shadow-md transition-all">+<?= number_format($ingreso->dinero, 2, ',', '.') ?>€</p>

                                        <!-- Formulario simulado para eliminar (o simple botón) -->
                                        <form action="<?= base_url('ingresos/eliminar') ?>" method="POST" class="m-0" onsubmit="return confirm('<?= tr('confirmEliminarIngreso') ?? '¿Estás seguro de que quieres eliminar este ingreso?' ?>');">
                                            <!-- Simulamos el ID -->
                                            <input type="hidden" name="id" value="<?= $ingreso->id ?>">
                                            <button type="submit" class="p-2 bg-black/20 text-white/40 hover:text-white hover:bg-red-500 rounded-full transition-all duration-300 opacity-50 group-hover:opacity-100" title="<?= tr('titleEliminarIngreso') ?? 'Eliminar Ingreso' ?>" data-tr-title="titleEliminarIngreso">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>