<?php 
    /**
     * Admin App Entry Point
     * 
     * Handles all admin HTTP requests:
     * - app init 
     * - routing
     * - controller execution
     * - error handling
     * 
     * IMPORTANT: only this file should be accessible from the web, 
     * all other files should be protected from direct access.
     */
    declare(strict_types=1);
    session_start();
    header("Content-Type: text/html; charset=UTF-8");

    require_once __DIR__ . '/../../admin-app/Core/Enviroment.php';
    require_once __DIR__ . '/../../admin-app/Middlewares/I18N.php';
    require_once __DIR__ . '/../../admin-app/Middlewares/Auth.php';
    require_once __DIR__ . '/../../admin-app/Helpers/i18n.php';

    Enviroment::load();
    $i18n = I18N::init();
    $uri = $i18n['uri'];
    $GLOBALS['locale'] = $i18n['locale'];
    $GLOBALS['lang'] = $i18n['lang'];

    // DEBUG: Log the URI being processed
    error_log("Admin app - REQUEST_URI: " . $_SERVER['REQUEST_URI'] . ", Processed URI: " . $uri);

    spl_autoload_register(function ($class) {
        $paths = [
            __DIR__ . '/../../admin-app/Controllers/',
            __DIR__ . '/../../admin-app/Models/',
            __DIR__ . '/../../admin-app/Core/',
        ];
    
        foreach ($paths as $path) {
            $file = $path . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    });

    $browserUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);  
    if ($browserUri !== '/' && str_ends_with($browserUri, '/')) {
        $targetPath = rtrim($browserUri, '/');
        $query = $_SERVER['QUERY_STRING'] ?? '';
        if ($query !== '') {
            $targetPath .= '?' . $query;
        }

        header('Location: ' . $targetPath, true, 301);
        exit;
    }

    // Admin routes only
    $routes = [
        '/' => ['AdminAuthController', 'index'],
        '/login' => ['AdminAuthController', 'login'],
        '/logout' => ['AdminAuthController', 'logout'],
        '/dashboard' => ['AdminDashboardController', 'index'],
        '/content' => ['AdminContentController', 'index'],
        '/content/create' => ['AdminContentController', 'create'],
        '/content/store' => ['AdminContentController', 'store'],
        '/content/edit/<id>' => ['AdminContentController', 'edit'],
        '/content/<id>/edit' => ['AdminContentController', 'edit'],
        '/content/<id>/delete' => ['AdminContentController', 'delete'],
        '/content-tags' => ['AdminContentTagsController', 'index'],
        '/content-tags/create' => ['AdminContentTagsController', 'create'],
        '/content-tags/store' => ['AdminContentTagsController', 'store'],
        '/content-tags/edit/<id>' => ['AdminContentTagsController', 'edit'],
        '/content-tags/<id>/edit' => ['AdminContentTagsController', 'edit'],
        '/content-tags/<id>/delete' => ['AdminContentTagsController', 'delete'],
        '/products' => ['AdminProductController', 'index'],
        '/products/create' => ['AdminProductController', 'create'],
        '/products/store' => ['AdminProductController', 'store'],
        '/products/edit/<id>' => ['AdminProductController', 'edit'],
        '/products/<id>/edit' => ['AdminProductController', 'edit'],
        '/products/<id>/delete' => ['AdminProductController', 'delete'],
        '/orders' => ['AdminOrderController', 'index'],
        '/orders/create' => ['AdminOrderController', 'create'],
        '/orders/store' => ['AdminOrderController', 'store'],
        '/orders/edit/<id>' => ['AdminOrderController', 'edit'],
        '/orders/<id>/edit' => ['AdminOrderController', 'edit'],
        '/orders/<id>/delete' => ['AdminOrderController', 'delete'],
        '/customers' => ['AdminCustomerController', 'index'],
        '/customers/create' => ['AdminCustomerController', 'create'],
        '/customers/store' => ['AdminCustomerController', 'store'],
        '/customers/edit/<id>' => ['AdminCustomerController', 'edit'],
        '/customers/<id>/edit' => ['AdminCustomerController', 'edit'],
        '/customers/<id>/delete' => ['AdminCustomerController', 'delete'],
        '/error' => ['ErrorController', 'index'],
    ];

    function getErrorDescription(int $errorCode): string {
        $errorDescriptions = [
            404 => 'Page Not Found',
            500 => 'Internal Server Error',
        ];

        return $errorDescriptions[$errorCode] ?? 'Unknown Error';
    }

    function matchRoute($uri, $routes) {
        if (array_key_exists($uri, $routes)) {
            return ['controller' => $routes[$uri][0], 'method' => $routes[$uri][1], 'params' => []];
        }

        foreach ($routes as $routePattern => $routeHandler) {
            $pattern = preg_replace('/<([a-z_]+)>/', '(?P<$1>[^/]+)', $routePattern);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_numeric($key)) {
                        $params[$key] = $value;
                    }
                }
                return [
                    'controller' => $routeHandler[0],
                    'method' => $routeHandler[1],
                    'params' => $params
                ];
            }
        }

        return null;
    }

    $match = matchRoute($uri, $routes);

    if ($match !== null) {
        [$controller, $method, $params] = [$match['controller'], $match['method'], $match['params']];

        if (!class_exists($controller) || !method_exists($controller, $method)) {
            $errorCode = 502;
            $errorDescription = getErrorDescription($errorCode);
            (new ErrorController())->index($errorCode, $errorDescription);
            exit;
        }

        try {
            $instance = new $controller();
            $instance->$method(...array_values($params));
        } catch (Exception $e) {
            $errorCode = 500;
            $errorDescription = getErrorDescription($errorCode);
            (new ErrorController())->index($errorCode, $errorDescription);
        }
    } else {
        $errorCode = 404;
        $errorDescription = getErrorDescription($errorCode);
        (new ErrorController())->index($errorCode, $errorDescription);
    }
?>
