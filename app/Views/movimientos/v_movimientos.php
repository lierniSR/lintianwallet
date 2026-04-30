<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="menuMovimientos"><?= tr('menuMovimientos') ?? 'Movimientos' ?> | Lintian Wallet</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-purple-400/30">

    <?= view('plantillas/p_menu.php') ?>

    <!-- === Vista de Movimientos: Listado detallado de ingresos y gastos === -->
    <main class="max-w-7xl mx-auto mt-10 px-4">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight" data-tr="tituloMovimientos"><?= tr('tituloMovimientos') ?? 'Tus Movimientos' ?></h1>
                <p class="text-purple-100 mt-2 font-medium" data-tr="subtituloMovimientos"><?= tr('subtituloMovimientos') ?? 'Visualiza todo el flujo de tu dinero en un solo lugar.' ?></p>
            </div>

            <!-- Selector de cuentas para filtrar movimientos -->
            <div class="flex items-center gap-4">
                <!-- Select de Cuentas -->
                <?php if (!empty($cuentas) && (!isset($_GET['cuenta_id']) || (isset($_GET['from']) && $_GET['from'] === 'menu'))): ?>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <select onchange="window.location.href='<?= base_url('movimientos') ?>?cuenta_id=' + this.value + '&from=menu'" class="appearance-none w-full md:min-w-[300px] pl-11 pr-10 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-2xl border border-white/20 text-white font-medium focus:outline-none focus:ring-2 focus:ring-purple-400/50 transition-all cursor-pointer">
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
            </div>
        </div>

        <!-- Diseño a dos bloques: Lateral izquierdo para resumen, derecho para la lista de movimientos -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna lateral: Gráfica / Info rápida de la cuenta -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gradient-to-br from-[#8b5cf6] to-[#5b21b6] p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <p class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2" data-tr="saldoCuentaMovimientos"><?= tr('saldoCuentaMovimientos') ?? 'Saldo de la Cuenta' ?></p>
                        <h2 class="text-4xl font-extrabold text-white mb-1"><?= number_format($saldoCuenta ?? 0, 2, ',', '.') ?> €</h2>
                    </div>
                </div>
            </div>

            <!-- Columna principal: Lista de Movimientos -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden min-h-[500px]">
                    <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white" data-tr="todosMovimientos"><?= tr('todosMovimientos') ?? 'Todos los Movimientos' ?></h3>
                    </div>

                    <!-- Zona donde se imprimen los movimientos o el mensaje de 'No hay movimientos' -->
                    <div class="p-4 space-y-2">
                        <?php if (empty($movimientos)): ?>
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/5">
                                    <svg class="w-10 h-10 text-purple-300/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-white font-bold text-xl mb-1" data-tr="noHayMovimientos"><?= tr('noHayMovimientos') ?? 'No hay movimientos' ?></h4>
                                <p class="text-purple-200/60 text-sm" data-tr="descNoHayMovimientos"><?= tr('descNoHayMovimientos') ?? 'Aún no se ha registrado ningún ingreso o gasto.' ?></p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($movimientos as $mov): ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-transparent hover:border-white/10 transition-all duration-300 cursor-pointer group">
                                    <div class="flex items-center gap-5">
                                        <?php if ($mov->tipo == 'ingreso'): ?>
                                            <div class="w-12 h-12 rounded-full bg-[#29C6AD]/20 text-[#29C6AD] flex items-center justify-center font-bold shadow-inner transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold text-lg leading-tight" data-tr="ingresoN"><?= tr('ingresoN') ?? 'Ingreso Nº' ?><?= esc($mov->id) ?></h4>
                                                <p class="text-white/50 text-sm font-medium mt-0.5">
                                                    <?= date('d M Y', strtotime($mov->fecha)) ?> • <span class="text-green-300" data-tr="labelIngreso"><?= tr('labelIngreso') ?? 'Ingreso' ?></span>
                                                </p>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-12 h-12 rounded-full bg-[#ef4444]/20 text-[#ef4444] flex items-center justify-center font-bold shadow-inner transition-transform">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold text-lg leading-tight"><?= esc($mov->subcategoria_nombre ?? (tr('gastoN') ?? 'Gasto Nº') . $mov->id) ?></h4>
                                                <p class="text-white/50 text-sm font-medium mt-0.5">
                                                    <?= date('d M Y', strtotime($mov->fecha)) ?> • <span class="text-red-300" data-tr="labelGasto"><?= tr('labelGasto') ?? 'Gasto' ?></span>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <?php if ($mov->tipo == 'ingreso'): ?>
                                            <p class="text-[#29C6AD] font-bold text-xl drop-shadow-sm">+<?= number_format($mov->dinero, 2, ',', '.') ?>€</p>
                                        <?php else: ?>
                                            <p class="text-[#ef4444] font-bold text-xl drop-shadow-sm">-<?= number_format($mov->dinero, 2, ',', '.') ?>€</p>
                                        <?php endif; ?>
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