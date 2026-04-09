<?php
// Calculamos el total de los gastos
$totalGastos = array_reduce($gastos, function ($carry, $item) {
    $dinero = isset($item->dinero) ? $item->dinero : 0;
    return $carry + $dinero;
}, 0);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos | Lintian Wallet</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#ef4444]/30">

    <?= view('plantillas/p_menu.php') ?>

    <main class="max-w-7xl mx-auto mt-10 px-4">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Tus Gastos</h1>
                <p class="text-purple-100 mt-2 font-medium">Controla y visualiza todas tus salidas de dinero.</p>
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
                        <select onchange="window.location.href='<?= base_url('gastos') ?>?cuenta_id=' + this.value" class="appearance-none w-full md:min-w-[300px] pl-11 pr-10 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-2xl border border-white/20 text-white font-medium focus:outline-none focus:ring-2 focus:ring-[#ef4444]/50 transition-all cursor-pointer">
                            <?php foreach ($cuentas as $c): ?>
                                <!-- Mostramos ID de tarjeta como indicativo básico -->
                                <option value="<?= $c->id ?>" <?= ($c->id == $cuenta_seleccionada) ? 'selected' : '' ?> class="bg-purple-800 text-white">
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

                <!-- Botón para Registrar Nuevo Gasto -->
                <?php if (!empty($cuenta_seleccionada)): ?>
                <a href="<?= base_url('gastos/new/' . esc($cuenta_seleccionada)) ?>" class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Registrar Gasto
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna lateral: Gráfica / Info rápida de gastos -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gradient-to-br from-[#ef4444] to-[#991b1b] p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <p class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2">Total de Gastos</p>
                        <h2 class="text-4xl font-extrabold text-white mb-1">-<?= number_format($totalGastos, 2, ',', '.') ?> €</h2>
                    </div>
                </div>
            </div>

            <!-- Columna principal: Lista de Gastos -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden min-h-[500px]">
                    <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h3 class="text-xl font-bold text-white">Últimos Movimientos</h3>
                            <?php if(session()->getFlashdata('success')): ?>
                                <div class="flex items-center gap-1.5 animate-pulse bg-green-500/20 px-3 py-1 rounded-full border border-green-500/30 mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-bold text-green-400 uppercase tracking-wide">
                                        <?= strpos(strtolower(session()->getFlashdata('success')), 'eliminad') !== false ? 'Eliminado' : 'Gastado' ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="p-4 space-y-2">
                        <?php if (empty($gastos)): ?>
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/5">
                                    <svg class="w-10 h-10 text-purple-300/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-white font-bold text-xl mb-1">No hay gastos todavía</h4>
                                <p class="text-purple-200/60 text-sm">Registra tu primer gasto para verlo reflejado aquí.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($gastos as $gasto): ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-transparent hover:border-white/10 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 rounded-full bg-[#ef4444]/20 text-[#ef4444] flex items-center justify-center font-bold shadow-inner group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold text-lg leading-tight"><?= esc($gasto->subcategoria_nombre ?? 'Gasto Nº' . $gasto->id) ?></h4>
                                            <p class="text-white/50 text-sm font-medium mt-0.5">
                                                <?= date('d M Y', strtotime($gasto->fecha)) ?> • <span class="text-purple-300">Gasto</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <p class="text-[#ef4444] font-bold text-xl drop-shadow-sm group-hover:drop-shadow-md transition-all">-<?= number_format($gasto->dinero, 2, ',', '.') ?>€</p>

                                        <!-- Formulario simulado para eliminar -->
                                        <form action="<?= base_url('gastos/eliminar') ?>" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este gasto?');">
                                            <input type="hidden" name="id" value="<?= $gasto->id ?>">
                                            <button type="submit" class="p-2 bg-black/20 text-white/40 hover:text-white hover:bg-red-500 rounded-full transition-all duration-300 opacity-50 group-hover:opacity-100" title="Eliminar Gasto">
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
