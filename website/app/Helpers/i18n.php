<?php

function get_i18n($key): string  {
    return $GLOBALS['lang'][$key] ?? $key;
}

function locale(): string {
    return $GLOBALS['locale'] ?? 'en';
}

function url($path = ''): string {
    $locale = locale();
    $path = ltrim($path, '/');
    return '/' . ($locale !== 'en' ? $locale . '/' : '') . $path;
}

?>