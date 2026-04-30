/**
 * SCRIPT DE TRADUCCIÓN AUTOMÁTICA (Lintian Wallet)
 */

// Referencia global a la función de traducción para uso externo
let globalTranslatePage = null;

/**
 * Inicializa el motor de traducción del cliente.
 * Carga el idioma guardado, los diccionarios y activa la detección de cambios.
 */
    const selectIdioma = document.getElementById("selectIdioma");
    const savedLang = localStorage.getItem("idioma") || "es";
    
    if (selectIdioma) selectIdioma.value = savedLang;

    let translations = null;

    async function cargarJSON() {
        try {
            const baseUrl = typeof LINTIAN_BASE_URL !== 'undefined' ? LINTIAN_BASE_URL : window.location.origin;
            const res = await fetch(baseUrl + '/jsoncontroller/traducciones');
            translations = await res.json();
            return translations;
        } catch (err) {
            console.error('Error al cargar traducciones:', err);
            return null;
        }
    }

    const setElementText = (el, text) => {
        if (el.tagName === 'INPUT' && (el.type === 'submit' || el.type === 'button')) {
            el.value = text;
        } else if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            el.placeholder = text;
        } else {
            el.innerHTML = text;
        }
    };

    /**
     * Traduce todos los elementos con atributos data-tr y data-tr-title de la página.
     * @param {string} lang - Código de idioma (es, eu, en, etc.)
     */
    const translatePage = async (lang) => {
        localStorage.setItem("idioma", lang);
        // Guardamos también en una cookie para que PHP pueda leerlo
        document.cookie = "idioma=" + lang + "; path=/; max-age=" + (30 * 24 * 60 * 60);
        
        if (selectIdioma) selectIdioma.value = lang;
        
        // Sincronizar todos los selectores personalizados (Menú y Configuración)
        const allDisplayTexts = document.querySelectorAll('.lang-display-text');
        const allDisplayFlags = document.querySelectorAll('.lang-display-flag');
        
        const names = { 
            es: 'Español', 
            en: 'English', 
            eu: 'Euskara', 
            fr: 'Français',
            pt: 'Português',
            it: 'Italiano',
            'zh-TW': 'Chino',
            ja: 'Japonés'
        };
        const baseUrl = typeof LINTIAN_BASE_URL !== 'undefined' ? LINTIAN_BASE_URL : '';
        const flags = {
            es: 'https://flagcdn.com/w20/es.png',
            en: 'https://flagcdn.com/w20/gb.png',
            eu: baseUrl + '/img/flags/euskara.jpg',
            fr: 'https://flagcdn.com/w20/fr.png',
            pt: 'https://flagcdn.com/w20/pt.png',
            it: 'https://flagcdn.com/w20/it.png',
            'zh-TW': 'https://flagcdn.com/w20/tw.png',
            ja: 'https://flagcdn.com/w20/jp.png'
        };

        allDisplayTexts.forEach(el => el.innerText = names[lang] || lang.toUpperCase());
        allDisplayFlags.forEach(el => {
            el.src = flags[lang] || 'https://flagcdn.com/w20/un.png';
            el.alt = lang;
            el.classList.add('border', 'border-gray-200', 'shadow-sm');
        });

        if (!translations) {
            translations = await cargarJSON();
        }
        if (!translations) return;

        const elements = document.querySelectorAll('[data-tr]');
        const tES = translations["es"];

        if (lang === "es" || lang === "eu") {
            const t = translations[lang];
            elements.forEach(el => {
                const key = el.getAttribute('data-tr');
                if (t && t[key]) {
                    setElementText(el, t[key]);
                }
            });

            // Traducción de Títulos (tooltips)
            const titleElements = document.querySelectorAll('[data-tr-title]');
            titleElements.forEach(el => {
                const key = el.getAttribute('data-tr-title');
                if (t && t[key]) {
                    el.title = t[key];
                }
            });
        } else {
            if (!("Translator" in window)) return;
            try {
                const translator = await Translator.create({
                    sourceLanguage: "es",
                    targetLanguage: lang
                });

                for (const el of elements) {
                    const key = el.getAttribute('data-tr');
                    const originalText = tES[key];
                    if (originalText) {
                        const translated = await translator.translate(originalText);
                        setElementText(el, translated);
                    }
                }

                // Traducción de Títulos con IA
                const titleElements = document.querySelectorAll('[data-tr-title]');
                for (const el of titleElements) {
                    const key = el.getAttribute('data-tr-title');
                    const originalText = tES[key];
                    if (originalText) {
                        const translated = await translator.translate(originalText);
                        el.title = translated;
                    }
                }
                translator.destroy();
            } catch (error) {
                console.error("Error en traducción IA:", error);
            }
        }
    };

    globalTranslatePage = translatePage;

    if (selectIdioma) {
        selectIdioma.addEventListener("change", () => translatePage(selectIdioma.value));
    }
    
    // Lógica para cerrar menús al hacer click fuera
    document.addEventListener("click", (e) => {
        const allDropdowns = document.querySelectorAll('.lang-dropdown-menu');
        allDropdowns.forEach(menu => {
            const container = menu.closest('.lang-dropdown-container');
            if (container && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });

    await translatePage(savedLang);
}

window.toggleLangMenu = (btn) => {
    const container = btn.closest('.lang-dropdown-container');
    const menu = container.querySelector('.lang-dropdown-menu');
    
    // Cerrar otros menús abiertos
    document.querySelectorAll('.lang-dropdown-menu').forEach(m => {
        if (m !== menu) m.classList.add('hidden');
    });

    menu.classList.toggle('hidden');
};

window.cambiarIdioma = (lang) => {
    // Cerrar el menú al seleccionar un idioma
    document.querySelectorAll('.lang-dropdown-menu').forEach(m => m.classList.add('hidden'));

    if (globalTranslatePage) {
        globalTranslatePage(lang);
    } else {
        localStorage.setItem("idioma", lang);
    }
};

document.addEventListener("DOMContentLoaded", initTraductor);
