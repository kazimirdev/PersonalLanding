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
const timestampDays30 = 30 * 24 * 60 * 60 * 1000;

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
        setCookie('theme', 'dark', timestampDays30);
    } else {
        document.documentElement.removeAttribute('data-theme');
        setCookie('theme', 'light', timestampDays30);
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

langSwitcher.addEventListener('change', async function() {
    let newLang = langSwitcher.checked ? 'pl' : 'en';

    setCookie('lang', newLang, timestampDays30);

    let path = window.location.pathname;
    path = path.replace(/^\/(en|pl)(\/|$)/, '/'); // Remove existing lang prefix
    if (newLang === 'en') {
    // wait 1s for better user experience when switching to English, 
    // 'cause the double visual change is a bit jarring when 
    // switching back to English from Polish
        await new Promise(resolve => setTimeout(resolve, 1000));
    }
    window.location.pathname = '/' + newLang + path; // Redirect to the new path

    // location.reload(); // Reload the page to apply language changes
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
            setCookie('fontSize', 'small', timestampDays30); // 30 days
        } else if (this.value === 'large') {
            document.documentElement.setAttribute('data-font-size', 'large');
            setCookie('fontSize', 'large', timestampDays30); // 30 days
        } else {
            document.documentElement.removeAttribute('data-font-size');
            setCookie('fontSize', 'medium', timestampDays30); // 30 days
        }
    });
});

// Page width:

if (currentPageWidth === 'narrow') {
    pageRadio.item(0).checked = true;
    document.documentElement.setAttribute('data-page-width', 'narrow');
} else if (currentPageWidth === 'wide') {
    pageRadio.item(1).checked = true;
    document.documentElement.setAttribute('data-page-width', 'wide');
} else {
    pageRadio.item(0).checked = true;
    document.documentElement.removeAttribute('data-page-width');
}; 

pageRadio.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'narrow') {
            document.documentElement.setAttribute('data-page-width', 'narrow');
            setCookie('pageWidth', 'narrow', timestampDays30);
        } else {
            document.documentElement.setAttribute('data-page-width', 'wide');
            setCookie('pageWidth', 'wide', timestampDays30);
        }
    });
});

})();
