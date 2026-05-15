<?php
    class ProductsController {
        public function index() {
            $prepage = url(getParentPage()) ?: '/';
            require __DIR__ . '/../Views/products/index.php';
        }
        
        public function show($slug) {
            $locale = I18N::get_locale();
            $productModel = new Store();
            $product = $productModel->selectBySlugAndLocale($slug, $locale);
            
            // If product doesn't exist, show 404 error page
            if (!$product) {
                $errorCode = 404;
                $errorDescription = 'Page Not Found';
                (new ErrorController())->index($errorCode, $errorDescription);
                return;
            }
            
            $prepage = url(getParentPage());
            require __DIR__ . '/../Views/products/show.php';
        }
    }
?>