<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();
$controller = new App\Controller();

// Define header - to pretty print JSON
$router->before('GET', '/.*', function () {
    header('Content-Type: application/json; charset=UTF-8');
});

////////////// PROVIDER ROUTES //////////////
$router->get('/products', function () use ($controller) {
    $limit = $_GET['limit'] ?? 10;
    $skip = $_GET['skip'] ?? 0;
    $sortBy = $_GET['sortBy'] ?? 'id';
    $order = $_GET['order'] ?? 'asc'; // Default
    $products = $controller->listProducts( $limit, $skip, $sortBy, $order);
    echo json_encode( $products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
});

$router->get('/products/(\d+)', function ($id) use ($controller) {
    $product = $controller->getProduct($id);
    echo json_encode( $product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
});

$router->get('/products/search', function () use ($controller) {
    $query = $_GET['q'] ?? '';
	$products = $controller->searchProducts($query);
	echo json_encode( $products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});

////////////// PARSER ROUTES //////////////
$router->get('/parsed/products', function () use ($controller) {
    $limit = $_GET['limit'] ?? 10;
    $skip = $_GET['skip'] ?? 0;
    $sortBy = $_GET['sortBy'] ?? 'id';
    $order = $_GET['order'] ?? 'asc'; // Default
    $products = $controller->listProductsParsed( $limit, $skip, $sortBy, $order );
    echo json_encode( $products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});

$router->get('/parsed/products/(\d+)', function ($id) use ($controller) {
    $product = $controller->getProductParsed($id);
    echo json_encode( $product, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});

$router->get('/parsed/products/search', function () use ($controller) {
    $query = $_GET['q'] ?? '';
    $products = $controller->searchProductsParsed($query);
    echo json_encode( $products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
});




// Home route
$router->get('/', function () {
    echo json_encode(['message' => 'Welcome to the API']);
});


// Run it!
$router->run();
