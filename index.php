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
    $limit = $_GET['limit'] ?? 10;
    $skip = $_GET['skip'] ?? 0;
    $sortBy = $_GET['sortBy'] ?? 'id';
    $order = $_GET['order'] ?? 'asc'; // Default
    $products = $controller->listProducts($limit, $skip, $sortBy, $order);
    echo json_encode($products, JSON_PRETTY_PRINT);
});

$router->get('/products/(\d+)', function ($id) use ($controller) {
    $product = $controller->getProduct($id);
    echo json_encode($product, JSON_PRETTY_PRINT);
});

$router->get('/products/search', function () use ($controller) {
    $query = $_GET['q'] ?? '';
	$products = $controller->searchProducts($query);
	echo json_encode($products, JSON_PRETTY_PRINT);
});

////////////// PARSER ROUTES //////////////
$router->get('/parsed/products', function () use ($controller) {
    $products = $controller->listProductsParsed();
    echo json_encode($products, JSON_PRETTY_PRINT);
});

$router->get('/parsed/products/(\d+)', function ($id) use ($controller) {
    $product = $controller->getProductParsed($id);
    echo json_encode($product, JSON_PRETTY_PRINT);
});

$router->get('/parsed/products/search', function () use ($controller) {
    $query = $_GET['q'] ?? '';
    $products = $controller->searchProductsParsed($query);
    echo json_encode($products, JSON_PRETTY_PRINT);
});




// Home route
$router->get('/', function () {
    echo json_encode(['message' => 'Welcome to the API']);
});


// Run it!
$router->run();
