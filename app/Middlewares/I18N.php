<?php

class I18N {
    public static array $supportedLocales = ['en', 'pl'];
    public static string $defaultLocale = 'en';

    public static function init(): array {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';
        $segments = array_values(array_filter(explode('/', $uri))); // Split URI into segments and reindex
        $locale = self::$defaultLocale;

        // 1. Check for locale in URL path
        if (isset($segments[0]) && preg_match('/^[a-z]{2}$/', $segments[0])) {
            if (isset($segments[0]) && in_array($segments[0], self::$supportedLocales)) { 
            // Fallback to default locale if the first segment is not a supported locale
            $locale = $segments[0];
            array_shift($segments); // Remove locale from segments   
            } else {
                $locale = self::$defaultLocale;
                array_shift($segments); // Remove the first segment even if it's not a valid locale to clean the URI
            } 
        } // 2. Check for locale in cookies
        elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::$supportedLocales)) {
            $locale = $_COOKIE['lang'];
        } // 3. Browser language detection 
        elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($browserLang, self::$supportedLocales)) {
                $locale = $browserLang;
            }
        }
        // save locale in cookie for future requests
        setcookie('lang', $locale, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        $lang = require __DIR__ . "/../Lang/$locale.php"; // Load language file based on the locale
        $cleanUri = '/' . implode('/', $segments); // Reconstruct URI without locale
        $cleanUri = $cleanUri === '/' ? '/' : rtrim($cleanUri, '/'); // Ensure root is just '/'
        return ['locale' => $locale, 'uri' => $cleanUri, 'lang' => $lang];
    }

    public static function getSupportedLocales(): array {
        return self::$supportedLocales;
    }
}
?>