<?php
// Datos de prueba (MOCK DATA) para simular los ingresos
$mockIngresos = [
    [
        'id' => 1,
        'concepto' => 'Nómina Mensual',
        'cantidad' => 2450.00,
        'fecha' => date('Y-m-d'),
        'categoria' => 'Salario',
        'icono' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'
    ],
    [
        'id' => 2,
        'concepto' => 'Bizum - Cena con amigos',
        'cantidad' => 35.50,
        'fecha' => date('Y-m-d', strtotime('-2 days')),
        'categoria' => 'Transferencias',
        'icono' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z'
    ],
    [
        'id' => 3,
        'concepto' => 'Venta de artículo (Wallapop)',
        'cantidad' => 120.00,
        'fecha' => date('Y-m-d', strtotime('-5 days')),
        'categoria' => 'Ventas',
        'icono' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'
    ],
    [
        'id' => 4,
        'concepto' => 'Devolución de la Renta',
        'cantidad' => 450.00,
        'fecha' => date('Y-m-d', strtotime('-15 days')),
        'categoria' => 'Impuestos',
        'icono' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos | Lintian Wallet</title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 pb-12 font-sans selection:bg-[#29C6AD]/30">

    <?= view('plantillas/p_menu.php') ?>

    <main class="max-w-7xl mx-auto mt-10 px-4">
        <!-- Cabecera -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">Tus Ingresos</h1>
                <p class="text-purple-100 mt-2 font-medium">Controla y visualiza todas tus entradas de dinero.</p>
            </div>

            <!-- Boton (simulado para futuros usos) -->
            <button class="flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-2xl border border-white/20 transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Registrar Ingreso
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna lateral: Gráfica / Info rápida de ingresos (simulada) -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gradient-to-br from-[#29C6AD] to-[#128a76] p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <p class="text-white/80 text-sm font-bold uppercase tracking-wider mb-2">Total de Ingresos</p>
                        <h2 class="text-4xl font-extrabold text-white mb-1">+3.055,50 €</h2>
                    </div>
                </div>
            </div>

            <!-- Columna principal: Lista de Ingresos -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden min-h-[500px]">
                    <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white">Últimos Movimientos</h3>
                        <span class="text-sm font-medium text-purple-200 cursor-pointer hover:text-white transition-colors">Ver todos</span>
                    </div>

                    <div class="p-4 space-y-2">
                        <?php foreach ($mockIngresos as $ingreso): ?>
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-transparent hover:border-white/10 transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-full bg-[#29C6AD]/20 text-[#29C6AD] flex items-center justify-center font-bold shadow-inner group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-bold text-lg leading-tight"><?= esc($ingreso['concepto']) ?></h4>
                                        <p class="text-white/50 text-sm font-medium mt-0.5">
                                            <?= date('d M Y', strtotime($ingreso['fecha'])) ?> • <span class="text-purple-300"><?= esc($ingreso['categoria']) ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="text-[#29C6AD] font-bold text-xl drop-shadow-sm group-hover:drop-shadow-md transition-all">+<?= number_format($ingreso['cantidad'], 2, ',', '.') ?>€</p>
                                    
                                    <!-- Formulario simulado para eliminar (o simple botón) -->
                                    <form action="#" method="POST" class="m-0" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este ingreso?');">
                                        <!-- Simulamos el ID -->
                                        <input type="hidden" name="id" value="<?= $ingreso['id'] ?>">
                                        <button type="submit" class="p-2 bg-black/20 text-white/40 hover:text-white hover:bg-red-500 rounded-full transition-all duration-300 opacity-50 group-hover:opacity-100" title="Eliminar Ingreso">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>