<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';



$router = new \Bramus\Router\Router();
$controller = new App\Controller();

// Define header - to pretty print JSON
$router->before('GET', '/.*', function () {
    header('Content-Type: application/json');
});

////////////// PROVIDER ROUTES //////////////
$router->get('/products', function () use ($controller) {
    $products = $controller->listProducts();
    echo json_encode($products, JSON_PRETTY_PRINT);
});

$router->get('/products/(\d+)', function ($id) use ($controller) {
    $product = $controller->getProduct($id);
    echo json_encode($product, JSON_PRETTY_PRINT);
});

$router->get('/products/search/(\w+)', function ($query) use ($controller) {
	$products = $controller->searchProducts($query);
	echo json_encode($products, JSON_PRETTY_PRINT);
});

////////////// PARSER ROUTES //////////////


// Home route
$router->get('/', function () {
    echo json_encode(['message' => 'Welcome to the API']);
});


// Run it!
$router->run();
