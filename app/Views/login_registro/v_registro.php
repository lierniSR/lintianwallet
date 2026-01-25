<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 p-10">
    <select id="selectIdioma" class="p-2 rounded border border-gray-300 bg-white mb-5">
        <option value="es">Español</option>
        <option value="en">English</option>
        <option value="fr">Frances</option>
        <option value="eu">Euskera</option>
        <option value="pt">Portugues</option>
        <option value="it">Italiano</option>
        <option value="zh-TW">Chino</option>
        <option value="ja">Japones</option>
    </select>
    <div class="grid grid-cols-[1fr_auto_1fr] items-center justify-center h-screen bg-white rounded-xl">
        <div class="flex flex-col items-center justify-center col-span-1 p-5">
            <h1 id="tituloApp" class="text-4xl font-bold text-center"></h1>
            <img src="img/logo.png" alt="Logo" class="w-72 h-72">
            <p id="eslogan" class="text-center"></p>
            <button id="botonRegistro" class="px-6 py-2 rounded-full bg-[#29C6AD] mt-5 text-white font-bold hover:bg-[#23a893] transition duration-300 shadow-lg">
            </button>
        </div>
        <div class="h-3/4 w-1 bg-[#29C6AD] self-center"></div>
        <div class="flex flex-col items-center justify-center col-span-1">
            <h1 class="text-4xl font-bold text-center" id="titulo"></h1>
            <div class="flex flex-col items-center justify-center">
                <form class="flex flex-col gap-4 w-full max-w-sm mt-5">
                    <div class="flex flex-col">
                        <label for="dni" class="text-sm font-semibold">DNI</label>
                        <input type="text" id="dni" name="dni" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col">
                        <label for="nombre" class="text-sm font-semibold">Nombre</label>
                        <input type="text" name="nombre" id="nombre" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col">
                        <label for="apellido" class="text-sm font-semibold">Apellido</label>
                        <input type="text" name="apellido" id="apellido" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col">
                        <label for="gmail" class="text-sm font-semibold">Gmail</label>
                        <input type="email" name="gmail" id="gmail" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col">
                        <label for="password" class="text-sm font-semibold">Password</label>
                        <input type="password" name="password" id="password" required class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col">
                        <label for="fotoPerfil" class="text-sm font-semibold">Foto de perfil</label>
                        <input type="file" name="fotoPerfil" id="fotoPerfil" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-purple-600">
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <input type="submit" value="INICIAR SESION" class="w-50 px-6 py-2 rounded-full bg-[#29C6AD] mt-5 mb-5 text-white font-bold hover:bg-[#23a893] transition duration-300 shadow-lg">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let tituloES = "";
        let tituloEU = "";
        let esloganES = "";
        let esloganEU = "";
        let botonRegistroES = "";
        let botonRegistroEU = "";
        let tituloAppES = "";
        let tituloAppEU = "";

        async function cargarJSON() {
            // Obtener JSON de traducciones desde CodeIgniter
            try {
                const res = await fetch('jsoncontroller/traducciones');
                const data = await res.json();
                tituloES = data.es.tituloLogin;
                tituloEU = data.eu.tituloLogin;
                esloganES = data.es.eslogan;
                esloganEU = data.eu.eslogan;
                botonRegistroES = data.es.textoBotonRegistro;
                botonRegistroEU = data.eu.textoBotonRegistro;
                tituloAppES = data.es.tituloApp;
                tituloAppEU = data.eu.tituloApp;
            } catch (err) {
                console.error('Error al cargar traducciones:', err);
            }
        }

        async function cargarStrings() {
            await cargarJSON();
            document.getElementById("titulo").innerHTML = tituloES;
            document.getElementById("eslogan").innerHTML = esloganES;
            document.getElementById("botonRegistro").innerHTML = botonRegistroES;
            document.getElementById("tituloApp").innerHTML = tituloAppES;
        }

        document.addEventListener("DOMContentLoaded", cargarStrings);


        document.getElementById("selectIdioma").addEventListener("change", async () => {
            if (document.getElementById("selectIdioma").value == "eu") {
                document.getElementById("titulo").innerHTML = tituloEU;
                document.getElementById("eslogan").innerHTML = esloganEU;
                document.getElementById("botonRegistro").innerHTML = botonRegistroEU;
                document.getElementById("tituloApp").innerHTML = tituloAppEU;
                return;
            }
            if (document.getElementById("selectIdioma").value == "es") {
                document.getElementById("titulo").innerHTML = tituloES;
                document.getElementById("eslogan").innerHTML = esloganES;
                document.getElementById("botonRegistro").innerHTML = botonRegistroES;
                document.getElementById("tituloApp").innerHTML = tituloAppES;
                return;
            }
            if (!("Translator" in window)) {
                console.error("La API Translator no está disponible en este navegador.");
                return;
            }
            try {
                const translator = await Translator.create({
                    sourceLanguage: "es",
                    targetLanguage: document.getElementById("selectIdioma").value
                });

                const traduccionTituloLogin = await translator.translate(tituloES);
                const traduccionEsLoganLogin = await translator.translate(esloganES);
                const traduccionBotonRegistro = await translator.translate(botonRegistroES);
                const traduccionTituloApp = await translator.translate(tituloAppES);

                translator.destroy();

                document.getElementById("titulo").innerHTML = traduccionTituloLogin.toUpperCase();
                document.getElementById("eslogan").innerHTML = traduccionEsLoganLogin;
                document.getElementById("botonRegistro").innerHTML = traduccionBotonRegistro.toUpperCase();
                document.getElementById("tituloApp").innerHTML = traduccionTituloApp;
            } catch (error) {
                console.error("Error al traducir:", error);
            }
        });
    </script>
</body>

</html>