<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="img/logo.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body class="relative min-h-screen bg-gradient-to-b from-purple-600 via-purple-700 to-blue-900 p-10">
    <select id="selectIdioma" class="p-2 rounded border border-gray-300 bg-white mb-5">
        <option value="es">Español</option>
        <option value="en">English</option>
        <option value="fr">Frances</option>
        <option value="eu">Euskera</option>
    </select>
    <div class="flex flex-col items-center justify-center h-screen bg-white rounded-xl">
        <h1 class="text-4xl font-bold text-black" id="titulo">INICIAR SESIÓN</h1>
    </div>
    <button id="btnTraducir">
        <span>Click me</span>
    </button>
    <script>
        let tituloES = "";
        let tituloEU = "";

        // Obtener JSON de traducciones desde CodeIgniter
        fetch('jsoncontroller/traducciones')
            .then(res => res.json())
            .then(data => {
                tituloES = data.es.tituloLogin;
                tituloEU = data.eu.tituloLogin;
            })
            .catch(err => console.error('Error al cargar traducciones:', err));



        document.getElementById("selectIdioma").addEventListener("change", async () => {
            if (document.getElementById("selectIdioma").value == "eu") {
                document.getElementById("titulo").innerHTML = tituloEU;
                return;
            }
            if (document.getElementById("selectIdioma").value == "es") {
                document.getElementById("titulo").innerHTML = tituloES;
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

                translator.destroy();
                document.getElementById("titulo").innerHTML = traduccionTituloLogin.toUpperCase();
            } catch (error) {
                console.error("Error al traducir:", error);
            }
        });
    </script>
</body>

</html>