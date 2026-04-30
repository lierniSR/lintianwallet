<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 px-4 py-8 md:p-10 flex flex-col items-center justify-center">
    <!-- Bloqueo de Seguridad para Móviles/Tablets -->
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

        <!-- Language Selector: Now inside the card, positioned absolutely top-right -->
        <div class="absolute top-4 right-4 z-20">
            <select id="selectIdioma" class="p-1.5 rounded-md border border-gray-200 text-gray-600 text-sm bg-gray-50 hover:bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#29C6AD] transition-colors">
                <option value="es">Español</option>
                <option value="en">Inglés</option>
                <option value="fr">Frances</option>
                <option value="eu">Euskera</option>
                <option value="pt">Portugues</option>
                <option value="it">Italiano</option>
                <option value="zh-TW">Chino</option>
                <option value="ja">Japones</option>
            </select>
        </div>

        <!-- Decoration/Background blobs could be added here if needed, but keeping it clean per request -->

        <!-- === Div izquierdo: Información de la Aplicación y Logo === -->
        <div class="flex flex-col items-center justify-center w-full h-full order-1 md:order-none mt-6 md:mt-0">
            <h1 id="tituloApp" class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-4 transition-all duration-300"></h1>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <img src="img/logo.png" alt="Logo" class="relative w-48 h-48 md:w-56 md:h-56 lg:w-64 lg:h-64 object-contain mb-4 transform group-hover:scale-105 transition duration-300">
            </div>

            <p id="eslogan" class="text-center text-gray-600 font-medium px-4"></p>

            <?= form_open('/registro', ['class' => 'w-full flex justify-center mt-6']) ?>
            <button id="botonRegistro" class="px-8 py-2.5 rounded-full bg-[#29C6AD] text-white font-bold tracking-wide hover:bg-[#23a893] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
            </button>
            <?= form_close() ?>
        </div>

        <!-- === Div medio: Raya separadora estética === -->
        <!-- En móvil (sm) la línea es en horizontal, en escritorio (md) se transpone a formato vertical -->
        <div class="w-full h-px md:w-px md:h-64 bg-gray-200 md:bg-gradient-to-b md:from-transparent md:via-gray-300 md:to-transparent order-2 md:order-none my-2 md:my-0"></div>

        <!-- Div derecho: Login Form -->
        <div class="flex flex-col items-center justify-center w-full h-full order-3 md:order-none">
            <h1 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-8" id="titulo"></h1>

            <div class="w-full flex flex-col items-center justify-center">
                <!-- Errores de validación -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 animate-pulse" role="alert">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium"><?= esc(session()->getFlashdata('error')) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- FORMULARIO PARA INICIAR SESIÓN -->
                <!-- Apunta a la función de validación de contraseña en nuestro Controlador -->
                <?= form_open('/autenticar', ['class' => 'flex flex-col gap-6 w-full']) ?>

                <div class="flex flex-col group">
                    <?= form_label('', 'dni', ['class' => 'text-sm font-semibold text-gray-600 mb-1.5 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'dniLabel']) ?>

                    <?= form_input([
                        'type'        => 'text',
                        'name'        => 'dni',
                        'id'          => 'dni',
                        'value'       => old('dni'),
                        'required'    => true,
                        'placeholder' => 'Ej. 12345678A',
                        'class'       => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all duration-200 bg-gray-50 focus:bg-white'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <?= form_label('', 'contrasenia', ['class' => 'text-sm font-semibold text-gray-600 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'passwordLabel']) ?>
                    </div>

                    <?= form_password([
                        'name'        => 'contrasenia',
                        'id'          => 'contrasenia',
                        'required'    => true,
                        'placeholder' => 'Ej. ****',
                        'class'       => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all duration-200 bg-gray-50 focus:bg-white'
                    ]) ?>
                </div>

                <div class="flex flex-col items-center justify-center mt-2">
                    <?= form_submit('botonInicio', '', [
                        'id'    => 'botonInicio',
                        'class' => 'w-full px-8 py-3.5 rounded-full bg-gradient-to-r from-[#29C6AD] to-[#23a893] text-white font-bold text-lg hover:shadow-lg hover:to-[#1f9683] transform hover:-translate-y-0.5 transition-all duration-300 cursor-pointer'
                    ]) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    <script>
        // =========================================================
        // SCRIPT PARA MANEJAR LAS TRADUCCIONES DEL TEXTO
        // =========================================================
        
        // Variables vacías preparadas para guardar el texto original en español y euskera
        let tituloES = "";
        let tituloEU = "";
        let esloganES = "";
        let esloganEU = "";
        let botonRegistroES = "";
        let botonRegistroEU = "";
        let tituloAppES = "";
        let tituloAppEU = "";
        let dniES = "";
        let dniEU = "";
        let passwordES = "";
        let passwordEU = "";
        let botonInicioES = "";
        let botonInicioEU = "";

        //Función para cargar los datos del archivo JSON writable/data/strings.json
        async function cargarJSON() {
            try {
                //La llamada va a un $route del archivo Routes.php
                const res = await fetch('jsoncontroller/traducciones');
                const data = await res.json();

                //Por cada campo se obtiene el string de es o eu
                tituloES = data.es.tituloLogin;
                tituloEU = data.eu.tituloLogin;
                esloganES = data.es.eslogan;
                esloganEU = data.eu.eslogan;
                botonRegistroES = data.es.textoBotonRegistro;
                botonRegistroEU = data.eu.textoBotonRegistro;
                tituloAppES = data.es.tituloApp;
                tituloAppEU = data.eu.tituloApp;
                dniES = data.es.dni;
                dniEU = data.eu.dni;
                passwordES = data.es.contrasenia;
                passwordEU = data.eu.contrasenia;
                botonInicioES = data.es.tituloLogin;
                botonInicioEU = data.eu.tituloLogin;
            } catch (err) {
                console.error('Error al cargar traducciones:', err);
            }
        }

        //Función que llama a cargarJSON y después pone por cada campo los strings ES
        async function cargarStrings() {
            await cargarJSON();
            document.getElementById("titulo").innerHTML = tituloES;
            document.getElementById("eslogan").innerHTML = esloganES;
            document.getElementById("botonRegistro").innerHTML = botonRegistroES;
            document.getElementById("tituloApp").innerHTML = tituloAppES;
            document.getElementById("dniLabel").innerHTML = dniES;
            document.getElementById("passwordLabel").innerHTML = passwordES;
            document.getElementById("botonInicio").value = botonInicioES;
        }

        //Se le añade un escuchador para cargar strings al iniciar la página
        document.addEventListener("DOMContentLoaded", cargarStrings);


        //Se le añade un escuchador para utilizar API de traductor IA por cada vez que se cambia el valor del select
        document.getElementById("selectIdioma").addEventListener("change", async () => {
            //Si el valor seleccionado es EU se cambia del data del json
            if (document.getElementById("selectIdioma").value == "eu") {
                document.getElementById("titulo").innerHTML = tituloEU;
                document.getElementById("eslogan").innerHTML = esloganEU;
                document.getElementById("botonRegistro").innerHTML = botonRegistroEU;
                document.getElementById("tituloApp").innerHTML = tituloAppEU;
                document.getElementById("dniLabel").innerHTML = dniEU;
                document.getElementById("passwordLabel").innerHTML = passwordEU;
                document.getElementById("botonInicio").value = botonInicioEU;
                return;
            }
            //Si el valor seleccionado es ES se cambia del data del json
            if (document.getElementById("selectIdioma").value == "es") {
                document.getElementById("titulo").innerHTML = tituloES;
                document.getElementById("eslogan").innerHTML = esloganES;
                document.getElementById("botonRegistro").innerHTML = botonRegistroES;
                document.getElementById("tituloApp").innerHTML = tituloAppES;
                document.getElementById("dniLabel").innerHTML = dniES;
                document.getElementById("passwordLabel").innerHTML = passwordES;
                document.getElementById("botonInicio").value = botonInicioES;
                return;
            }
            //Si no llegará al traductor IA
            if (!("Translator" in window)) {
                console.error("La API Translator no está disponible en este navegador.");
                return;
            }
            try {
                //Se crea la traducción con la API de la IA traductor
                const translator = await Translator.create({
                    sourceLanguage: "es",
                    targetLanguage: document.getElementById("selectIdioma").value
                });

                //Se crean todas las traducciones
                const traduccionTituloLogin = await translator.translate(tituloES);
                const traduccionEsLoganLogin = await translator.translate(esloganES);
                const traduccionBotonRegistro = await translator.translate(botonRegistroES);
                const traduccionTituloApp = await translator.translate(tituloAppES);
                const traduccionDNI = await translator.translate(dniES);
                const traduccionPassword = await translator.translate(passwordES);
                const traduccionBotonLogin = await translator.translate(botonInicioES);

                //Se destruye el traductor
                translator.destroy();

                //Poner cada traducción en su campo
                document.getElementById("titulo").innerHTML = traduccionTituloLogin.toUpperCase();
                document.getElementById("eslogan").innerHTML = traduccionEsLoganLogin;
                document.getElementById("botonRegistro").innerHTML = traduccionBotonRegistro.toUpperCase();
                document.getElementById("tituloApp").innerHTML = traduccionTituloApp;
                document.getElementById("dniLabel").innerHTML = traduccionDNI;
                document.getElementById("passwordLabel").innerHTML = traduccionPassword;
                document.getElementById("botonInicio").value = traduccionBotonLogin.toUpperCase();
            } catch (error) {
                console.error("Error al traducir:", error);
            }
        });
    </script>
</body>

</html>