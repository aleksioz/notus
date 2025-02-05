<?php
/*
* This is the Provider class. It is responsible for fetching data from the API.
* It uses Guzzle to make HTTP requests to the API.
*/

namespace App;

use GuzzleHttp\Client;

class Provider
{
    private $client;

    public function __construct() {
        $this->client = new Client(['base_uri' => 'https://dummyjson.com/']);
    }

    /**
     * Get a list of products
     *
     * @param int $limit
     * @param int $skip
     * @param string $sortBy
     * @param string $order
     * @return array The list of products
     */
    public function getProducts($limit = 10, $skip = 0, $sortBy = 'id', $order = 'asc'){
        try {
            $response = $this->client->get('products', [
                'query' => [
                    'limit' => $limit,
                    'skip' => $skip,
                    'sortBy' => $sortBy,
                    'order' => $order
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Error fetching products');
            }

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Handle the exception as needed
            return ['error' => $e->getMessage()];
        }
    }




    /**
     * Get a product by its ID
     *
     * @param int $id The ID of the product
     * @return array The product data
     */
    public function getProductById($id){
        try{
            $response = $this->client->get("products/{$id}");

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Error fetching products');
            }

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Handle the exception as needed
            return ['error' => $e->getMessage()];
        }
    }



    /**
     * Search for products by a query string
     *
     * @param string $query The search query
     * @return array The list of products matching the query
     */
    public function searchProducts($query){
        try{

            $response = $this->client->get('products/search', [
                'query' => ['q' => $query]
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Error fetching products');
            }

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            // Handle the exception as needed
            return ['error' => $e->getMessage()];
        }
    }
}