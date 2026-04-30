<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="tituloLogin"><?= tr('tituloLogin') ?? 'Iniciar sesión' ?></title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 px-4 py-8 md:p-10 flex flex-col items-center justify-center">
    <!-- Bloqueo de Seguridad: Impide el acceso desde dispositivos móviles por políticas de seguridad -->
    <script>
        (function() {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

            if (isMobile) {
                document.body.style.overflow = 'hidden';
                const warning = document.createElement('div');
                warning.style.position = 'fixed';
                warning.style.top = '0';
                warning.style.left = '0';
                warning.style.width = '100vw';
                warning.style.height = '100vh';
                warning.style.backgroundColor = 'rgba(15, 23, 42, 0.98)';
                warning.style.backdropFilter = 'blur(12px)';
                warning.style.zIndex = '9999';
                warning.style.display = 'flex';
                warning.style.flexDirection = 'column';
                warning.style.alignItems = 'center';
                warning.style.justifyContent = 'center';
                warning.style.color = 'white';
                warning.style.padding = '2rem';
                warning.style.textAlign = 'center';
                warning.style.fontFamily = 'sans-serif';

                warning.innerHTML = `
                    <div style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 3rem; rounded: 2rem; border-radius: 2rem; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                        <div style="background: #ef4444; width: 80px; height: 80px; border-radius: 50%; display: flex; items-center; justify-content: center; margin: 0 auto 2rem; border: 4px solid rgba(239, 68, 68, 0.3);">
                            <svg style="width: 40px; height: 40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.025em;">Acceso Restringido</h1>
                        <p style="font-size: 1.125rem; color: #cbd5e1; line-height: 1.6; margin-bottom: 2rem;">
                            Por motivos de <strong>seguridad avanzada</strong>, el acceso a Lintian Wallet desde dispositivos móviles o tablets no está permitido.
                        </p>
                        <div style="height: 1px; background: rgba(255,255,255,0.1); margin-bottom: 2rem;"></div>
                        <p style="font-size: 0.875rem; color: #94a3b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em;">
                            Por favor, accede desde un ordenador personal.
                        </p>
                    </div>
                `;
                document.body.innerHTML = '';
                document.body.appendChild(warning);
            }
        })();
    </script>

    <!-- Contenedor padre principal que envuelve todo el bloque central -->
    <!-- CSS: En móviles se pone en columna (flex-col). En ordenadores se divide en 3 columnas espaciadas (grid-cols) -->
    <div class="flex flex-col md:grid md:grid-cols-[1fr_auto_1fr] items-center justify-center w-full max-w-sm md:max-w-5xl h-auto p-6 md:p-10 bg-white rounded-xl shadow-2xl gap-8 md:gap-8 lg:gap-12 relative overflow-hidden">

        <!-- Language Selector: Now with click toggle -->
        <div class="absolute top-4 right-4 z-20 lang-dropdown-container">
            <button onclick="toggleLangMenu(this)" class="flex items-center gap-2 px-3 py-1.5 bg-white/80 backdrop-blur-sm hover:bg-white rounded-xl border border-gray-200 shadow-sm transition-all cursor-pointer">
                <img class="lang-display-flag w-5 h-auto rounded-sm" src="https://flagcdn.com/w20/es.png" alt="flag">
                <span class="lang-display-text text-xs font-bold text-gray-600 uppercase">ES</span>
                <svg class="w-3 h-3 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <!-- Hidden Select for compatibility -->
            <select id="selectIdioma" class="hidden">
                <option value="es">Español</option>
                <option value="eu">Euskara</option>
                <option value="en">English</option>
                <option value="fr">Français</option>
                <option value="pt">Português</option>
                <option value="it">Italiano</option>
                <option value="zh-TW">Chino</option>
                <option value="ja">Japonés</option>
            </select>
            <!-- Dropdown Menu -->
            <div class="lang-dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 transition-all">
                <button onclick="cambiarIdioma('es')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/es.png" class="w-5 h-auto rounded-sm" alt="ES"> Español
                </button>
                <button onclick="cambiarIdioma('eu')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="<?= base_url('img/flags/euskara.jpg') ?>" class="w-5 h-auto rounded-sm" alt="EU"> Euskara
                </button>
                <button onclick="cambiarIdioma('en')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm" alt="EN"> English
                </button>
                <button onclick="cambiarIdioma('fr')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/fr.png" class="w-5 h-auto rounded-sm" alt="FR"> Français
                </button>
                <button onclick="cambiarIdioma('pt')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/pt.png" class="w-5 h-auto rounded-sm" alt="PT"> Português
                </button>
                <button onclick="cambiarIdioma('it')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/it.png" class="w-5 h-auto rounded-sm" alt="IT"> Italiano
                </button>
                <button onclick="cambiarIdioma('zh-TW')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/tw.png" class="w-5 h-auto rounded-sm" alt="ZH"> Chino
                </button>
                <button onclick="cambiarIdioma('ja')" class="w-full flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 text-gray-700 text-sm font-medium transition-colors text-left">
                    <img src="https://flagcdn.com/w20/jp.png" class="w-5 h-auto rounded-sm" alt="JA"> Japonés
                </button>
            </div>
        </div>

        <!-- Decoration/Background blobs could be added here if needed, but keeping it clean per request -->

        <!-- === Columna Izquierda: Identidad Visual y Eslogan === -->
        <div class="flex flex-col items-center justify-center w-full h-full order-1 md:order-none mt-6 md:mt-0">
            <h1 id="tituloApp" data-tr="tituloApp" class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-4 transition-all duration-300"><?= tr('tituloApp') ?? 'LintianWallet' ?></h1>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <img src="img/logo.png" alt="Logo" class="relative w-48 h-48 md:w-56 md:h-56 lg:w-64 lg:h-64 object-contain mb-4 transform group-hover:scale-105 transition duration-300">
            </div>

            <p id="eslogan" data-tr="eslogan" class="text-center text-gray-600 font-medium px-4"><?= tr('eslogan') ?? 'Menos likes a las compras, más a tu bolsillo, !<b>LintianWallet</b> guarda tu dinero como si fuera suyo!' ?></p>

            <?= form_open('/registro', ['class' => 'w-full flex justify-center mt-6']) ?>
            <button id="botonRegistro" data-tr="textoBotonRegistro" class="px-8 py-2.5 rounded-full bg-[#29C6AD] text-white font-bold tracking-wide hover:bg-[#23a893] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                <?= tr('textoBotonRegistro') ?? 'REGISTRARSE' ?>
            </button>
            <?= form_close() ?>
        </div>

        <!-- === Div medio: Raya separadora estética === -->
        <!-- En móvil (sm) la línea es en horizontal, en escritorio (md) se transpone a formato vertical -->
        <div class="w-full h-px md:w-px md:h-64 bg-gray-200 md:bg-gradient-to-b md:from-transparent md:via-gray-300 md:to-transparent order-2 md:order-none my-2 md:my-0"></div>

        <!-- === Columna Derecha: Formulario de Acceso === -->
        <div class="flex flex-col items-center justify-center w-full h-full order-3 md:order-none">
            <h1 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-8 mt-10" id="titulo" data-tr="tituloLogin"><?= tr('tituloLogin') ?? 'INICIAR SESION' ?></h1>

            <div class="w-full flex flex-col items-center justify-center">
                <!-- Errores de validación -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 animate-pulse" role="alert">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium" data-tr="<?= esc(session()->getFlashdata('error')) ?>"><?= tr(session()->getFlashdata('error')) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- FORMULARIO PARA INICIAR SESIÓN -->
                <!-- Apunta a la función de validación de contraseña en nuestro Controlador -->
                <?= form_open('/autenticar', ['class' => 'flex flex-col gap-6 w-full']) ?>

                <div class="flex flex-col group">
                    <?= form_label(tr('dni') ?? 'DNI', 'dni', ['class' => 'text-sm font-semibold text-gray-600 mb-1.5 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'dniLabel', 'data-tr' => 'dni']) ?>

                    <?= form_input([
                        'type'        => 'text',
                        'name'        => 'dni',
                        'id'          => 'dni',
                        'value'       => old('dni'),
                        'required'    => true,
                        'placeholder' => tr('placeholderDniLogin') ?? 'Ej. 12345678A',
                        'data-tr'     => 'placeholderDniLogin',
                        'class'       => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all duration-200 bg-gray-50 focus:bg-white'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <?= form_label(tr('contrasenia') ?? 'Contraseña', 'contrasenia', ['class' => 'text-sm font-semibold text-gray-600 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'passwordLabel', 'data-tr' => 'contrasenia']) ?>
                    </div>

                    <?= form_password([
                        'name'        => 'contrasenia',
                        'id'          => 'contrasenia',
                        'required'    => true,
                        'placeholder' => tr('placeholderContraseniaLogin') ?? 'Ej. ****',
                        'data-tr'     => 'placeholderContraseniaLogin',
                        'class'       => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all duration-200 bg-gray-50 focus:bg-white'
                    ]) ?>
                </div>

                <div class="flex flex-col items-center justify-center mt-2">
                    <?= form_submit('botonInicio', tr('tituloLogin') ?? 'INICIAR SESION', [
                        'id'      => 'botonInicio',
                        'data-tr' => 'tituloLogin',
                        'class'   => 'w-full px-8 py-3.5 rounded-full bg-gradient-to-r from-[#29C6AD] to-[#23a893] text-white font-bold text-lg hover:shadow-lg hover:to-[#1f9683] transform hover:-translate-y-0.5 transition-all duration-300 cursor-pointer'
                    ]) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    <script>
        const LINTIAN_BASE_URL = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('js/traductor.js') ?>"></script>
</body>

</html>