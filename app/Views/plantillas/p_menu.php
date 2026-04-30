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
                        <span data-tr="menuCuentas"><?= tr('menuCuentas') ?? 'Cuentas' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('movimientos') ?>" class="<?= $d_base ?> <?= $isActive('movimientos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span data-tr="menuMovimientos"><?= tr('menuMovimientos') ?? 'Movimientos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('gastos') ?>" class="<?= $d_base ?> <?= $isActive('gastos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span data-tr="menuGastos"><?= tr('menuGastos') ?? 'Gastos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('ingresos') ?>" class="<?= $d_base ?> <?= $isActive('ingresos') ? $d_active : $d_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span data-tr="menuIngresos"><?= tr('menuIngresos') ?? 'Ingresos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('configuracion') ?>" class="<?= $d_base ?> <?= $isActive('configuracion') ? $d_active : $d_inactive ?> !px-2" title="<?= tr('tituloConfiguracion') ?? 'Configuración' ?>" data-tr-title="tituloConfiguracion">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                </li>

                <li class="flex items-center gap-3 ml-4 pl-4 border-l border-gray-200">
                    <!-- Foto de Perfil Redonda -->
                    <?php if (session()->get('dni')): ?>
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                            <img src="<?= base_url('usuario/foto/' . session()->get('dni')) ?>"
                                alt="Perfil"
                                class="relative h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-100">
                        </div>
                    <?php endif; ?>

                    <!-- Selector de Idioma (Solo Banderas) -->
                    <div class="relative lang-dropdown-container">
                        <button onclick="toggleLangMenu(this)" class="flex items-center justify-center p-1.5 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200 transition-all cursor-pointer">
                            <img class="lang-display-flag w-5 h-auto rounded-sm border border-gray-200 shadow-sm" src="https://flagcdn.com/w20/es.png" alt="flag">
                            <svg class="ml-1 w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Dropdown -->
                        <div class="lang-dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 transition-all">
                            <button onclick="cambiarIdioma('es')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/es.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="ES"> Español
                            </button>
                            <button onclick="cambiarIdioma('eu')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="<?= base_url('img/flags/euskara.jpg') ?>" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="EU"> Euskara
                            </button>
                            <button onclick="cambiarIdioma('en')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="EN"> English
                            </button>
                            <button onclick="cambiarIdioma('fr')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/fr.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="FR"> Français
                            </button>
                            <button onclick="cambiarIdioma('pt')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/pt.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="PT"> Português
                            </button>
                            <button onclick="cambiarIdioma('it')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/it.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="IT"> Italiano
                            </button>
                            <button onclick="cambiarIdioma('zh-TW')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/tw.png" class="w-5 h-auto rounded-sm border border-gray-100 shadow-sm" alt="ZH"> Chino
                            </button>
                            <button onclick="cambiarIdioma('ja')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-purple-50 text-gray-700 text-sm font-medium transition-colors text-left">
                                <img src="https://flagcdn.com/w20/jp.png" class="w-5 h-auto rounded-sm border border-gray-200 shadow-sm" alt="JA"> Japonés
                            </button>
                        </div>
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
                        <span data-tr="menuCuentas"><?= tr('menuCuentas') ?? 'Cuentas' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('movimientos') ?>" class="<?= $m_base ?> <?= $isActive('movimientos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span data-tr="menuMovimientos"><?= tr('menuMovimientos') ?? 'Movimientos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('gastos') ?>" class="<?= $m_base ?> <?= $isActive('gastos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span data-tr="menuGastos"><?= tr('menuGastos') ?? 'Gastos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('ingresos') ?>" class="<?= $m_base ?> <?= $isActive('ingresos') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span data-tr="menuIngresos"><?= tr('menuIngresos') ?? 'Ingresos' ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('configuracion') ?>" class="<?= $m_base ?> <?= $isActive('configuracion') ? $m_active : $m_inactive ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span data-tr="tituloConfiguracion"><?= tr('tituloConfiguracion') ?? 'Configuración' ?></span>
                    </a>
                </li>
                <li class="pt-4 mt-4 border-t border-gray-100">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-widest mb-2" data-tr="labelIdioma"><?= tr('labelIdioma') ?? 'Idioma' ?></p>
                    <div class="grid grid-cols-2 gap-2 px-2">
                        <button onclick="cambiarIdioma('es')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/es.png" class="w-5 h-auto rounded-sm" alt="ES"> ES
                        </button>
                        <button onclick="cambiarIdioma('eu')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="<?= base_url('img/flags/euskara.jpg') ?>" class="w-5 h-auto rounded-sm" alt="EU"> EU
                        </button>
                        <button onclick="cambiarIdioma('en')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm" alt="EN"> EN
                        </button>
                        <button onclick="cambiarIdioma('fr')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/fr.png" class="w-5 h-auto rounded-sm" alt="FR"> FR
                        </button>
                        <button onclick="cambiarIdioma('pt')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/pt.png" class="w-5 h-auto rounded-sm" alt="PT"> PT
                        </button>
                        <button onclick="cambiarIdioma('it')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/it.png" class="w-5 h-auto rounded-sm" alt="IT"> IT
                        </button>
                        <button onclick="cambiarIdioma('zh-TW')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/tw.png" class="w-5 h-auto rounded-sm" alt="ZH"> ZH
                        </button>
                        <button onclick="cambiarIdioma('ja')" class="flex items-center gap-2 p-3 rounded-xl bg-gray-50 text-sm font-medium text-gray-600">
                            <img src="https://flagcdn.com/w20/jp.png" class="w-5 h-auto rounded-sm" alt="JA"> JA
                        </button>
                    </div>
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
<script>
    const LINTIAN_BASE_URL = '<?= base_url() ?>';
</script>
<script src="<?= base_url('js/traductor.js') ?>"></script>