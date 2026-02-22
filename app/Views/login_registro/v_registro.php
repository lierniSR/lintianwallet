<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 px-4 py-8 md:p-10 flex flex-col items-center justify-center">

    <!-- Div padre -->
    <!-- Mobile: Flex column. Desktop: Grid 3 columns -->
    <div class="flex flex-col md:grid md:grid-cols-[1fr_auto_1fr] items-center justify-center w-full max-w-sm md:max-w-5xl h-auto p-6 md:p-10 bg-white rounded-xl shadow-2xl gap-8 md:gap-8 lg:gap-12 relative overflow-hidden">

        <!-- Language Selector: Inside the card, positioned absolutely top-right -->
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

        <!-- Div izquierdo: App Info -->
        <div class="flex flex-col items-center justify-center w-full h-full order-1 md:order-none mt-6 md:mt-0">
            <h1 id="tituloApp" class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-4 transition-all duration-300"></h1>

            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <img src="img/logo.png" alt="Logo" class="relative w-48 h-48 md:w-56 md:h-56 lg:w-64 lg:h-64 object-contain mb-4 transform group-hover:scale-105 transition duration-300">
            </div>

            <p id="eslogan" class="text-center text-gray-600 font-medium px-4"></p>

            <?= form_open('/login', ['class' => 'w-full flex justify-center mt-6']) ?>
            <button id="botonInicio" class="px-8 py-2.5 rounded-full bg-[#29C6AD] text-white font-bold tracking-wide hover:bg-[#23a893] hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
            </button>
            <?= form_close() ?>
        </div>

        <!-- Div medio: Separator -->
        <div class="w-full h-px md:w-px md:h-64 bg-gray-200 md:bg-gradient-to-b md:from-transparent md:via-gray-300 md:to-transparent order-2 md:order-none my-2 md:my-0"></div>

        <!-- Div derecho: Registro Form -->
        <div class="flex flex-col items-center justify-center w-full h-full order-3 md:order-none">
            <h1 class="text-3xl lg:text-4xl font-bold text-center text-gray-800 mb-8" id="titulo"></h1>

            <div class="w-full flex flex-col items-center justify-center">
                <!-- Errores de validación -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="w-full bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6" role="alert">
                        <ul class="text-sm list-disc list-inside font-medium">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulario de Registro -->
                <?= form_open_multipart('/autenticarRegistro', ['class' => 'flex flex-col gap-4 w-full']) ?>

                <div class="flex flex-col group">
                    <?= form_label('', 'dni', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'dniLabel']) ?>
                    <?= form_input([
                        'type'        => 'text',
                        'name'        => 'dni',
                        'id'          => 'dni',
                        'value'       => old('dni'),
                        'required'    => true,
                        'placeholder' => '12345678A',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col group">
                        <?= form_label('', 'nombre', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'nombreLabel']) ?>
                        <?= form_input([
                            'type'        => 'text',
                            'name'        => 'nombre',
                            'id'          => 'nombre',
                            'value'       => old('nombre'),
                            'required'    => true,
                            'placeholder' => 'Juan',
                            'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                        ]) ?>
                    </div>
                    <div class="flex flex-col group">
                        <?= form_label('', 'apellido', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'apellidoLabel']) ?>
                        <?= form_input([
                            'type'        => 'text',
                            'name'        => 'apellido',
                            'id'          => 'apellido',
                            'value'       => old('apellido'),
                            'required'    => true,
                            'placeholder' => 'Pérez',
                            'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                        ]) ?>
                    </div>
                </div>

                <div class="flex flex-col group">
                    <?= form_label('', 'gmail', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'gmailLabel']) ?>
                    <?= form_input([
                        'type'        => 'email',
                        'name'        => 'gmail',
                        'id'          => 'gmail',
                        'value'       => old('gmail'),
                        'required'    => true,
                        'placeholder' => 'juan@gmail.com',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <?= form_label('', 'contrasenia', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'passwordLabel']) ?>
                    <?= form_password([
                        'name'        => 'contrasenia',
                        'id'          => 'contrasenia',
                        'required'    => true,
                        'placeholder' => '****',
                        'class'       => 'w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#29C6AD]/50 focus:border-[#29C6AD] transition-all bg-gray-50 focus:bg-white text-sm'
                    ]) ?>
                </div>

                <div class="flex flex-col group">
                    <?= form_label('', 'fotoPerfil', ['class' => 'text-xs font-semibold text-gray-600 mb-1 ml-1 transition-colors group-focus-within:text-[#29C6AD]', 'id' => 'fotoPerfilLabel']) ?>
                    <?= form_input([
                        'type'        => 'file',
                        'name'        => 'fotoPerfil',
                        'id'          => 'fotoPerfil',
                        'class'       => 'w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#29C6AD]/10 file:text-[#29C6AD] hover:file:bg-[#29C6AD]/20 transition-all'
                    ]) ?>
                </div>

                <div class="flex flex-col items-center justify-center mt-2">
                    <?= form_submit('botonRegistro', '', [
                        'id'    => 'botonRegistro',
                        'class' => 'w-full px-8 py-3 rounded-full bg-gradient-to-r from-[#29C6AD] to-[#23a893] text-white font-bold hover:shadow-lg hover:to-[#1f9683] transform hover:-translate-y-0.5 transition-all duration-300 cursor-pointer'
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
        let nombreES = "";
        let nombreEU = "";
        let apellidoES = "";
        let apellidoEU = "";
        let gmailES = "";
        let gmailEU = "";
        let fotoES = "";
        let fotoEU = "";
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
                tituloES = data.es.textoBotonRegistro;
                tituloEU = data.eu.textoBotonRegistro;
                esloganES = data.es.eslogan;
                esloganEU = data.eu.eslogan;
                botonRegistroES = data.es.textoBotonRegistro;
                botonRegistroEU = data.eu.textoBotonRegistro;
                tituloAppES = data.es.tituloApp;
                tituloAppEU = data.eu.tituloApp;
                dniES = data.es.dni;
                dniEU = data.eu.dni;
                nombreES = data.es.nombre;
                nombreEU = data.eu.nombre;
                apellidoES = data.es.apellido;
                apellidoEU = data.eu.apellido;
                gmailES = data.es.gmail;
                gmailEU = data.eu.gmail;
                fotoES = data.es.fotoPerfil;
                fotoEU = data.eu.fotoPerfil;
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
            document.getElementById("botonRegistro").value = botonRegistroES;
            document.getElementById("tituloApp").innerHTML = tituloAppES;
            document.getElementById("dniLabel").innerHTML = dniES;
            document.getElementById("nombreLabel").innerHTML = nombreES;
            document.getElementById("apellidoLabel").innerHTML = apellidoES;
            document.getElementById("gmailLabel").innerHTML = gmailES;
            document.getElementById("fotoPerfilLabel").innerHTML = fotoES;
            document.getElementById("passwordLabel").innerHTML = passwordES;
            document.getElementById("botonInicio").innerHTML = botonInicioES;
        }

        //Se le añade un escuchador para cargar strings al iniciar la página
        document.addEventListener("DOMContentLoaded", cargarStrings);


        //Se le añade un escuchador para utilizar API de traductor IA por cada vez que se cambia el valor del select
        document.getElementById("selectIdioma").addEventListener("change", async () => {
            //Si el valor seleccionado es EU se cambia del data del json
            if (document.getElementById("selectIdioma").value == "eu") {
                document.getElementById("titulo").innerHTML = tituloEU;
                document.getElementById("eslogan").innerHTML = esloganEU;
                document.getElementById("botonRegistro").value = botonRegistroEU;
                document.getElementById("tituloApp").innerHTML = tituloAppEU;
                document.getElementById("dniLabel").innerHTML = dniEU;
                document.getElementById("nombreLabel").innerHTML = nombreEU;
                document.getElementById("apellidoLabel").innerHTML = apellidoEU;
                document.getElementById("gmailLabel").innerHTML = gmailEU;
                document.getElementById("fotoPerfilLabel").innerHTML = fotoEU;
                document.getElementById("passwordLabel").innerHTML = passwordEU;
                document.getElementById("botonInicio").innerHTML = botonInicioEU;
                return;
            }
            //Si el valor seleccionado es ES se cambia del data del json
            if (document.getElementById("selectIdioma").value == "es") {
                document.getElementById("titulo").innerHTML = tituloES;
                document.getElementById("eslogan").innerHTML = esloganES;
                document.getElementById("botonRegistro").value = botonRegistroES;
                document.getElementById("tituloApp").innerHTML = tituloAppES;
                document.getElementById("dniLabel").innerHTML = dniES;
                document.getElementById("nombreLabel").innerHTML = nombreES;
                document.getElementById("apellidoLabel").innerHTML = apellidoES;
                document.getElementById("gmailLabel").innerHTML = gmailES;
                document.getElementById("fotoPerfilLabel").innerHTML = fotoES;
                document.getElementById("passwordLabel").innerHTML = passwordES;
                document.getElementById("botonInicio").innerHTML = botonInicioES;
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
                const traduccionNombre = await translator.translate(nombreES);
                const traduccionApellido = await translator.translate(apellidoES);
                const traduccionGmail = await translator.translate(gmailES);
                const traduccionFotoPerfil = await translator.translate(fotoES);
                const traduccionPassword = await translator.translate(passwordES);
                const traduccionBotonLogin = await translator.translate(botonInicioES);

                //Se destruye el traductor
                translator.destroy();

                //Poner cada traducción en su campo
                document.getElementById("titulo").innerHTML = traduccionTituloLogin.toUpperCase();
                document.getElementById("eslogan").innerHTML = traduccionEsLoganLogin;
                document.getElementById("botonRegistro").value = traduccionBotonRegistro.toUpperCase();
                document.getElementById("tituloApp").innerHTML = traduccionTituloApp;
                document.getElementById("dniLabel").innerHTML = traduccionDNI;
                document.getElementById("nombreLabel").innerHTML = traduccionNombre;
                document.getElementById("apellidoLabel").innerHTML = traduccionApellido;
                document.getElementById("gmailLabel").innerHTML = traduccionGmail;
                document.getElementById("fotoPerfilLabel").innerHTML = traduccionFotoPerfil;
                document.getElementById("passwordLabel").innerHTML = traduccionPassword;
                document.getElementById("botonInicio").innerHTML = traduccionBotonLogin.toUpperCase();
            } catch (error) {
                console.error("Error al traducir:", error);
            }
        });
    </script>
</body>

</html>