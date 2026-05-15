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

function getParentPage(string $currentUri = ''): string {
    // If no URI provided, try to get from globals
    if (empty($currentUri)) {
        $currentUri = $GLOBALS['current_uri'] ?? '/';
    }
    
    $currentUri = rtrim($currentUri, '/');
    
    // If root, return root
    if ($currentUri === '' || $currentUri === '/') {
        return '/';
    }
    
    // Remove the last segment
    $segments = array_filter(explode('/', $currentUri));
    array_pop($segments);
    
    // Reconstruct the parent path
    $parentPath = '/' . implode('/', $segments);
    $parentPath = $parentPath === '/' ? '/' : rtrim($parentPath, '/');
    
    return $parentPath;
}

?>