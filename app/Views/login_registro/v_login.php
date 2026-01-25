<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 p-10 flex flex-col items-center justify-center">
    <!-- Select para los idiomas -->
    <select id="selectIdioma" class="p-2 rounded border border-gray-300 bg-white mb-5">
        <option value="es">Español</option>
        <option value="en">Inglés</option>
        <option value="fr">Frances</option>
        <option value="eu">Euskera</option>
        <option value="pt">Portugues</option>
        <option value="it">Italiano</option>
        <option value="zh-TW">Chino</option>
        <option value="ja">Japones</option>
    </select>
    <!-- Div padre -->
    <div class="grid grid-cols-[1fr_auto_1fr] items-center justify-center h-auto p-10 bg-white rounded-xl shadow-2xl">
        <!-- Div izquierdo -->
        <div class="flex flex-col items-center justify-center col-span-1 p-5">
            <h1 id="tituloApp" class="text-4xl font-bold text-center"></h1>
            <img src="img/logo.png" alt="Logo" class="w-72 h-72">
            <p id="eslogan" class="text-center"></p>

            <?= form_open('/registro') ?>
            <button id="botonRegistro" class="px-6 py-2 rounded-full bg-[#29C6AD] mt-5 text-white font-bold hover:bg-[#23a893] transition duration-300 shadow-lg">
            </button>
            <?= form_close() ?>
        </div>
        <!-- Div medio -->
        <div class="h-3/4 w-1 bg-[#29C6AD] self-center"></div>
        <!-- Div derecho -->
        <div class="flex flex-col items-center justify-center col-span-1">
            <h1 class="text-4xl font-bold text-center" id="titulo"></h1>
            <div class="flex flex-col items-center justify-center">
                <!-- Errores de validación -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 w-full max-w-sm" role="alert">
                        <ul class="list-disc list-inside">
                            <li><?= esc(session()->getFlashdata('error')) ?></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <!--Formulario para inciar sesión -->
                <?= form_open('/autenticar', ['class' => 'flex flex-col gap-4 w-full max-w-sm mt-5']) ?>

                <div class="flex flex-col">
                    <?= form_label('', 'dni', ['class' => 'text-sm font-semibold', 'id' => 'dniLabel']) ?>

                    <?= form_input([
                        'type'        => 'text',
                        'name'        => 'dni',
                        'id'          => 'dni',
                        'value'       => old('dni'),
                        'required'    => true,
                        'placeholder' => 'Ej. 12345678A',
                        'class'       => 'w-100 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600'
                    ]) ?>
                </div>

                <div class="flex flex-col">
                    <?= form_label('', 'contrasenia', ['class' => 'text-sm font-semibold', 'id' => 'passwordLabel']) ?>

                    <?= form_password([
                        'name'        => 'contrasenia',
                        'id'          => 'contrasenia',
                        'required'    => true,
                        'placeholder' => 'Ej. ****',
                        'class'       => 'w-100 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600'
                    ]) ?>
                </div>

                <div class="flex flex-col items-center justify-center">
                    <?= form_submit('botonInicio', '', [
                        'id'    => 'botonInicio',
                        'class' => 'w-50 px-6 py-2 rounded-full bg-[#29C6AD] mt-5 mb-5 text-white font-bold hover:bg-[#23a893] transition duration-300 shadow-lg'
                    ]) ?>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    <script>
        //Para que la traduccion funcione
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