(async () => {
    const mod = await import('./cookies.js');
    window.setCookie = mod.setCookie;
    window.getCookies = mod.getCookie;

let themeSwitcher = document.getElementById('theme-switcher');
let langSwitcher = document.getElementById('lang-switcher');
let fontRadio = document.querySelectorAll('input[name="font-size"]');
let pageRadio = document.querySelectorAll('input[name="page-width"]');
let currentTheme = getCookies('theme');
let currentLang = getCookies('lang');
let currentFontSize = getCookies('fontSize');
let currentPageWidth = getCookies('pageWidth');

// Theme

if (currentTheme === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
    themeSwitcher.checked = true;   
} else {
    document.documentElement.removeAttribute('data-theme');
    themeSwitcher.checked = false;
}

themeSwitcher.addEventListener('change', function() {
    if (themeSwitcher.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        setCookie('theme', 'dark', 30 * 24 * 60 * 60 * 1000); // 30 days
    } else {
        document.documentElement.removeAttribute('data-theme');
        setCookie('theme', 'light', 30 * 24 * 60 * 60 * 1000); // 30 days
    }
});

// Language

if (currentLang === 'pl') {
    document.documentElement.setAttribute('lang', 'pl');
    langSwitcher.checked = true;
} else {
    document.documentElement.removeAttribute('lang');
    langSwitcher.checked = false;
}

langSwitcher.addEventListener('change', function() {
    if (langSwitcher.checked) {
        document.documentElement.setAttribute('lang', 'pl');
        setCookie('lang', 'pl', 30 * 24 * 60 * 60 * 1000); // 30 days
    } else {
        document.documentElement.removeAttribute('lang');
        setCookie('lang', 'en', 30 * 24 * 60 * 60 * 1000); // 30 days
    }
});

// Text Size

if (currentFontSize === 'small') {
    fontRadio.item(0).checked = true;
    document.documentElement.setAttribute('data-font-size', 'small');

} else if (currentFontSize === 'large') {
    fontRadio.item(2).checked = true;
    document.documentElement.setAttribute('data-font-size', 'large');
} else {
    fontRadio.item(1).checked = true;
    document.documentElement.removeAttribute('data-font-size');
}

fontRadio.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'small') {
            document.documentElement.setAttribute('data-font-size', 'small');
            setCookie('fontSize', 'small', 30 * 24 * 60 * 60 * 1000); // 30 days
        } else if (this.value === 'large') {
            document.documentElement.setAttribute('data-font-size', 'large');
            setCookie('fontSize', 'large', 30 * 24 * 60 * 60 * 1000); // 30 days
        } else {
            document.documentElement.removeAttribute('data-font-size');
            setCookie('fontSize', 'medium', 30 * 24 * 60 * 60 * 1000); // 30 days
        }
    });
});




if (currentPageWidth === 'narrow') {
    document.documentElement.style.setProperty('--page-width', '80%');
} else if (currentPageWidth === 'wide') {
    document.documentElement.style.setProperty('--page-width', '120%');
} else {
    currentPageWidth = 'medium';
    document.documentElement.style.setProperty('--page-width', '100%');
}



})();