<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-tr="textoBotonRegistro"><?= tr('textoBotonRegistro') ?? 'REGISTRARSE' ?></title>
    <link rel="icon" href="<?= base_url('img/logo.ico') ?>">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 px-4 py-8 md:p-10 flex flex-col items-center justify-center">

    <!-- === Contenedor padre principal === -->
    <div class="flex flex-col md:grid md:grid-cols-[1fr_auto_1fr] items-center justify-center w-full max-w-sm md:max-w-5xl h-auto p-6 md:p-10 bg-white rounded-xl shadow-2xl gap-8 md:gap-8 lg:gap-12 relative overflow-hidden">

        <!-- Language Selector: Back inside the card, but with space -->
        <div class="absolute top-4 right-4 z-20 lang-dropdown-container">
            <button onclick="toggleLangMenu(this)" class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 rounded-xl border border-gray-200 shadow-sm transition-all cursor-pointer">
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

        <!-- === Div Izquierdo: Portada de la App y botón de Atajo === -->
        <div class="flex flex-col items-center justify-center w-full h-full order-1 md:order-none mt-6 md:mt-0">
            <h1 id="tituloApp" data-tr="tituloApp" class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-4 transition-all duration-300"><?= tr('tituloApp') ?? 'LintianWallet' ?></h1>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <img src="<?= base_url('img/logo.png') ?>" alt="Logo" class="relative w-48 h-48 md:w-56 md:h-56 lg:w-64 lg:h-64 object-contain mb-4 transform group-hover:scale-105 transition duration-300">
            </div>

            <p id="eslogan" data-tr="eslogan" class="text-center text-gray-600 font-medium px-4"><?= tr('eslogan') ?? 'Menos likes a las compras, más a tu bolsillo, !<b>LintianWallet</b> guarda tu dinero como si fuera suyo!' ?></p>

            <?= form_open('/login', ['class' => 'w-full flex justify-center mt-6']) ?>
            <button id="botonInicio" data-tr="tituloLogin" class="px-8 py-2.5 rounded-full bg-[#29C6AD] text-white font-bold tracking-wide hover:bg-[#23a893] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                <?= tr('tituloLogin') ?? 'INICIAR SESION' ?>
            </button>
            <?= form_close() ?>
        </div>

        <!-- === Div Medio: Línea separadora === -->
        <div class="w-full h-px md:w-px md:h-64 bg-gray-200 md:bg-gradient-to-b md:from-transparent md:via-gray-300 md:to-transparent order-2 md:order-none my-2 md:my-0"></div>

        <!-- === Div Derecho: FORMULARIO OFICIAL DE REGISTRO === -->
        <div class="flex flex-col items-center justify-center w-full h-full order-3 md:order-none">
            <h1 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-8 mt-10" id="titulo" data-tr="textoBotonRegistro"><?= tr('textoBotonRegistro') ?? 'REGISTRARSE' ?></h1>

            <div class="w-full flex flex-col items-center justify-center">
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6" role="alert">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <ul class="list-disc list-inside text-sm font-medium">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li data-tr="<?= esc($error) ?>"><?= tr($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6" role="alert">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm font-medium" data-tr="<?= esc(session()->getFlashdata('error')) ?>"><?= tr(session()->getFlashdata('error')) ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?= form_open_multipart('/autenticarRegistro', ['class' => 'flex flex-col gap-5 w-full']) ?>

                <div class="flex flex-col group">
                    <?= form_label(tr('dni') ?? 'DNI', 'dni', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'dniLabel', 'data-tr' => 'dni']) ?>
                    <?= form_input([
                        'type'        => 'text',
                        'name'        => 'dni',
                        'id'          => 'dni',
                        'value'       => old('dni'),
                        'required'    => true,
                        'placeholder' => tr('placeholderDniLogin') ?? '12345678A',
                        'data-tr'     => 'placeholderDniLogin',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col group">
                        <?= form_label(tr('nombre') ?? 'Nombre', 'nombre', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'nombreLabel', 'data-tr' => 'nombre']) ?>
                        <?= form_input([
                            'type'        => 'text',
                            'name'        => 'nombre',
                            'id'          => 'nombre',
                            'value'       => old('nombre'),
                            'required'    => true,
                            'placeholder' => tr('placeholderNombre') ?? 'Juan',
                            'data-tr'     => 'placeholderNombre',
                            'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                        ]) ?>
                    </div>
                    <div class="flex flex-col group">
                        <?= form_label(tr('apellido') ?? 'Apellido', 'apellido', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'apellidoLabel', 'data-tr' => 'apellido']) ?>
                        <?= form_input([
                            'type'        => 'text',
                            'name'        => 'apellido',
                            'id'          => 'apellido',
                            'value'       => old('apellido'),
                            'required'    => true,
                            'placeholder' => tr('placeholderApellido') ?? 'Pérez',
                            'data-tr'     => 'placeholderApellido',
                            'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                        ]) ?>
                    </div>
                </div>

                <div class="flex flex-col group">
                    <?= form_label(tr('gmail') ?? 'Gmail', 'gmail', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'gmailLabel', 'data-tr' => 'gmail']) ?>
                    <?= form_input([
                        'type'        => 'email',
                        'name'        => 'gmail',
                        'id'          => 'gmail',
                        'value'       => old('gmail'),
                        'required'    => true,
                        'placeholder' => tr('placeholderGmail') ?? 'juan@gmail.com',
                        'data-tr'     => 'placeholderGmail',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <?= form_label(tr('contrasenia') ?? 'Contraseña', 'contrasenia', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'passwordLabel', 'data-tr' => 'contrasenia']) ?>
                    <?= form_password([
                        'name'        => 'contrasenia',
                        'id'          => 'contrasenia',
                        'required'    => true,
                        'placeholder' => tr('placeholderContraseniaLogin') ?? '****',
                        'data-tr'     => 'placeholderContraseniaLogin',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <?= form_label(tr('fotoPerfil') ?? 'Foto de perfil', 'fotoPerfil', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'fotoPerfilLabel', 'data-tr' => 'fotoPerfil']) ?>
                    <?= form_input([
                        'type'        => 'file',
                        'name'        => 'fotoPerfil',
                        'id'          => 'fotoPerfil',
                        'class'       => 'w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#29C6AD]/10 file:text-[#29C6AD] hover:file:bg-[#29C6AD]/20 transition-all'
                    ]) ?>
                </div>

                <div class="flex flex-col items-center justify-center mt-2">
                    <?= form_submit('botonRegistro', tr('textoBotonRegistro') ?? 'REGISTRARSE', [
                        'id'      => 'botonRegistro',
                        'data-tr' => 'textoBotonRegistro',
                        'class'   => 'w-full px-8 py-3 rounded-full bg-gradient-to-r from-[#29C6AD] to-[#23a893] text-white font-bold hover:shadow-lg hover:to-[#1f9683] transform hover:-translate-y-0.5 transition-all duration-300 cursor-pointer'
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