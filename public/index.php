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

    header("Content-Type: text/html; charset=UTF-8"); // set content type header for proper encoding

    require_once __DIR__ . '/../app/Core/Env.php';
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
        // 07/04/2026 - added support for subdirectories in Controllers and Models (e.g., BlogController, PostsModel, etc.)
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
    // TODO: dynamic routes (/blog/{slug}, etc.)
    // TODO: middleware (auth, etc.)
    // TODO: HTTP method handling (GET, POST, etc.)
    $routes = [
        // key is the URI, 
        // value is an array with controller and method to call
        '/' => ['HomeController', 'index'],
        '/blog' => ['BlogController', 'index'],
        '/products' => ['ProductsController', 'index'],
        '/cv.pdf' => ['CVController', 'index'],
        '/error' => ['ErrorController', 'index']
    ];

    function getErrorDescription(int $errorCode): string {
        $errorDescriptions = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large',
            414 => 'URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Range Not Satisfiable',
            417 => 'Expectation Failed',
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity', 
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Too Early',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            451 => 'Unavailable For Legal Reasons',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected', 
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            520 => 'Unknown Error',
            521 => 'Web Server Is Down',
            522 => 'Connection Timed Out',
            523 => 'Origin Is Unreachable',
            524 => 'A Timeout Occurred',
            525 => 'SSL Handshake Failed', 
            526 => 'Invalid SSL Certificate',
            527 => 'Railgun Error',
            530 => 'Site Is Frozen',
        ];

        return $errorDescriptions[$errorCode] ?? 'Unknown Error';
    }

    // Check if the requested URI exists in the defined routes.
    if (array_key_exists($uri, $routes)) {
        // If the route exists (for example, /blog), 
        // extract the controller and method from the routes array.
        [$controller, $method] = $routes[$uri];

        // if the controller class does not exist 
        // or the method does not exist in the controller,
        if (!class_exists($controller) || !method_exists($controller, $method)) {
            $errorCode = 502;
            $errorDescription = getErrorDescription($errorCode);
            (new ErrorController())->index($errorCode, $errorDescription);
            exit;
        }
        // If the controller and method exist,
        // create an instance of the controller (for example, new HomeController())
        // and call the method (index in this case).
        (new $controller())->$method();
    } else {
        $errorCode = 404;
        $errorDescription = getErrorDescription($errorCode);
        (new ErrorController())->index($errorCode, $errorDescription);
    }
?>