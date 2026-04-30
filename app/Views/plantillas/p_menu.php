<?php
$reqUri = $_SERVER['REQUEST_URI'];
$isActive = function ($path) use ($reqUri) {
    return strpos($reqUri, $path) !== false;
};

// Clases base y dinámicas para el menú Desktop
$d_base = "flex items-center gap-2 transition-all duration-300 px-4 py-2 rounded-xl";
$d_active = "text-purple-700 bg-purple-100 font-semibold shadow-sm ring-1 ring-purple-200";
$d_inactive = "text-gray-600 font-medium hover:text-purple-600 hover:bg-purple-50";

// Clases base y dinámicas para el menú Móvil
$m_base = "flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300";
$m_active = "text-purple-700 bg-purple-100 font-semibold shadow-sm translate-x-2 ring-1 ring-purple-200";
$m_inactive = "text-gray-600 font-medium hover:bg-purple-50 hover:text-purple-600";
?>
<header class="sticky top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
    <nav class="w-full px-4 sm:px-6 lg:px-12">
        <div class="flex justify-between h-16 items-center">
            <!-- === Sección del Logo y Marca === -->
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <img src="<?= base_url('img/logo.png') ?>" alt="Logo" class="h-8 w-8 object-contain">
                <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Lintian Wallet</span>
            </div>

            <!-- === Menú Principal de Ordenador === -->
            <!-- Navigation Links (Desktop) -->
            <ul class="hidden md:flex space-x-2 items-center">
                <li>
                    <a href="<?= base_url('tarjetas') ?>" class="<?= $d_base ?> <?= $isActive('tarjetas') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Cuentas
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('movimientos') ?>" class="<?= $d_base ?> <?= $isActive('movimientos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Movimientos
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('gastos') ?>" class="<?= $d_base ?> <?= $isActive('gastos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        Gastos
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('ingresos') ?>" class="<?= $d_base ?> <?= $isActive('ingresos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Ingresos
                    </a>
                </li>
                <li>
                    <!-- Mantenemos /registro para la configuración temporalmente -->
                    <a href="/registro" class="<?= $d_base ?> <?= $isActive('registro') ? $d_active : $d_inactive ?> !px-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                </li>
            </ul>

            <!-- === Botón de Hamburguesa para Móviles === -->
            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="p-2 rounded-md text-gray-600 hover:text-purple-600 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- === Menú Desplegable Móvil === -->
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden pb-6 transition-all duration-300 ease-in-out">
            <ul class="flex flex-col space-y-1">
                <li>
                    <a href="<?= base_url('tarjetas') ?>" class="<?= $m_base ?> <?= $isActive('tarjetas') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Cuentas
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('movimientos') ?>" class="<?= $m_base ?> <?= $isActive('movimientos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        Movimientos
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('gastos') ?>" class="<?= $m_base ?> <?= $isActive('gastos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        Gastos
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('ingresos') ?>" class="<?= $m_base ?> <?= $isActive('ingresos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Ingresos
                    </a>
                </li>
                <li>
                    <a href="/registro" class="<?= $m_base ?> <?= $isActive('registro') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Configuración
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        menuButton.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    });
</script>