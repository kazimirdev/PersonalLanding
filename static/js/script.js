const themeSwitcher = document.getElementById('theme-switcher');
const langSwitcher = document.getElementById('lang-switcher');

themeSwitcher.addEventListener('change', function() {
    if (themeSwitcher.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
});

// TODO: Add lang switcher functionality
langSwitcher.addEventListener('change', function() {
    if (langSwitcher.checked) {
        document.documentElement.setAttribute('lang-theme', 'pl');
    } else {
        document.documentElement.removeAttribute('lang-theme');
    }
});