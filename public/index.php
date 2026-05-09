<?php 
    /**
     * This is the main entry point, aka front controller.
     * 
     * Here is handled all HTTP requests:
     * 
     * Here is also doing:
     * - app init 
     * - routing
     * - controller execution
     * - error handling
     * 
     * IMPORTANT: only this file should be accessible from the web, 
     * all other files should be protected from direct access.
     */
    declare(strict_types=1); // declare strict types for better type safety
    session_start(); // start the session for authentication and other session-based features
    header("Content-Type: text/html; charset=UTF-8"); // set content type header for proper encoding

    require_once __DIR__ . '/../app/Core/Enviroment.php';
    require_once __DIR__ . '/../app/Middlewares/I18N.php';
    require_once __DIR__ . '/../app/Helpers/i18n.php';

    Enviroment::load(); // load environment variables from .env file
    $i18n = I18N::init(); // initialize i18n and get locale, clean URI, and language data
    $uri = $i18n['uri']; // use the clean URI for routing
    $GLOBALS['locale'] = $i18n['locale']; // make locale available globally
    $GLOBALS['lang'] = $i18n['lang']; // make language data available globally

    spl_autoload_register(function ($class) {
        // spl_autoload_register is used to automatically load classes when they are needed,
        // it takes a callback function that will be called with the class name as an argument.
        // 07/04/2026 - added support for subdirectories in Controllers and Models (e.g., ContentController, PostsModel, etc.)
        $paths = [
            __DIR__ . '/../app/Controllers/',
            __DIR__ . '/../app/Models/',
            __DIR__ . '/../app/Core/',
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

    // Define the routes for the application.
    // TODO: dynamic routes (/content/{slug}, etc.)
    // TODO: middleware (auth, etc.)
    // TODO: HTTP method handling (GET, POST, etc.)
    $routes = [
        // key is the URI, 
        // value is an array with controller and method to call
        // public routes
        '/' => ['HomeController', 'index'],
        '/content' => ['ContentController', 'index'],
        '/content/<slug>' => ['ContentController', 'show'],
        '/products' => ['ProductsController', 'index'],
        '/products/<slug>' => ['ProductsController', 'show'],
        '/cv.pdf' => ['CVController', 'index'],
        '/error' => ['ErrorController', 'index'],
        // Admin routes
        '/admin' => ['AdminAuthController', 'index'],
        '/admin/login' => ['AdminAuthController', 'login'],
        '/admin/logout' => ['AdminAuthController', 'logout'],
        '/admin/dashboard' => ['AdminDashboardController', 'index'],
        '/admin/content' => ['AdminContentController', 'index'],
        '/admin/content/create' => ['AdminContentController', 'create'],
        '/admin/content/store' => ['AdminContentController', 'store'],
        '/admin/content/edit/<id>' => ['AdminContentController', 'edit'],
        '/admin/content-tags' => ['AdminContentTagsController', 'index'],
        '/admin/content-tags/create' => ['AdminContentTagsController', 'create'],
        '/admin/content-tags/edit/<id>' => ['AdminContentTagsController', 'edit'],
        '/admin/products' => ['AdminProductController', 'index'],
        '/admin/products/create' => ['AdminProductController', 'create'],
        '/admin/products/edit/<id>' => ['AdminProductController', 'edit'],
        '/admin/orders' => ['AdminOrderController', 'index'],
        '/admin/orders/create' => ['AdminOrderController', 'create'],
        '/admin/orders/edit/<id>' => ['AdminOrderController', 'edit'],

    ];

    function getErrorDescription(int $errorCode): string {
        $errorDescriptions = [
            404 => 'Page Not Found',
            500 => 'Internal Server Error',
        ];

        return $errorDescriptions[$errorCode] ?? 'Unknown Error';
    }

    function matchRoute($uri, $routes) {
        // First try exact match
        if (array_key_exists($uri, $routes)) {
            return ['controller' => $routes[$uri][0], 'method' => $routes[$uri][1], 'params' => []];
        }

        // Try dynamic routes with parameters
        foreach ($routes as $routePattern => $routeHandler) {
            // Convert route pattern like /content/<slug> to regex
            $pattern = preg_replace('/<([a-z_]+)>/', '(?P<$1>[^/]+)', $routePattern);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                // Extract only named captures (parameter values)
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

    // Try to match the requested URI against defined routes
    $match = matchRoute($uri, $routes);

    if ($match !== null) {
        [$controller, $method, $params] = [$match['controller'], $match['method'], $match['params']];

        // if the controller class does not exist 
        // or the method does not exist in the controller,
        if (!class_exists($controller) || !method_exists($controller, $method)) {
            $errorCode = 502;
            $errorDescription = getErrorDescription($errorCode);
            (new ErrorController())->index($errorCode, $errorDescription);
            exit;
        }
        // If the controller and method exist,
        // create an instance of the controller and call the method
        // passing extracted parameters if any exist
        $controllerInstance = new $controller();
        if (!empty($params)) {
            $controllerInstance->$method(...array_values($params));
        } else {
            $controllerInstance->$method();
        }
    } else {
        $errorCode = 404;
        $errorDescription = getErrorDescription($errorCode);
        (new ErrorController())->index($errorCode, $errorDescription);
    }
?>