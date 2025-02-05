<?php

namespace App;

class Controller
{
    private $provider;
    private $parser;

    public function __construct() {
        $this->provider = new Provider();
        $this->parser = new Parser();
    }

    // Provider methods
    public function listProducts($limit = 10, $skip = 0, $sortBy = 'id', $order = 'asc') {
        return $this->provider->getProducts($limit, $skip, $sortBy, $order);
    }

    public function getProduct($id) {
        return $this->provider->getProductById($id);
    }

    public function searchProducts($query) {
        return $this->provider->searchProducts($query);
    }

    // Parsed methods
    public function listProductsParsed($limit = 10, $skip = 0, $sortBy = 'id', $order = 'asc') {
        $products = $this->listProducts($limit, $skip, $sortBy, $order);

        if( isset($products['error']) ) {
            return $products['error'];
        }

        return $this->parser->productList($products);

    }

    public function getProductParsed($id) {
        $product = $this->getProduct($id);

        if( isset($product['error']) ) {
            return $product['error'];
        }

        return $this->parser->productDetail($product);
    }

    public function searchProductsParsed($query) {
        $products = $this->searchProducts($query);

        if( isset($products['error']) ) {
            return $products['error'];
        }
        
        return $this->parser->productList($products);
    }
}
