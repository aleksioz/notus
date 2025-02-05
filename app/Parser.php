<?php

namespace App;

class Parser
{

	public function productList($products_data) {
		$data = array_map( function($product) {
			return [
				'id' => $product['id'],
				'title' => $product['title'],
				'description' => $product['description'],
				'short_description' => substr($product['description'], 0, 30) . '...',
				'price' => number_format($product['price'], 2, ',', '.') . ' €',
				'stock' => $product['stock'] == 0 ? 'No stock' : ($product['stock'] < 5 ? 'Get it while you can' : 'On Stock'),
				'thumbnail' => $product['thumbnail']
			];
		}, $products_data['products']);

		$meta = [
			'total_pages' => ceil($products_data['total'] / $products_data['limit']),
            'page' => ($products_data['skip'] / $products_data['limit']) + 1,
            'per_page' => $products_data['limit'],
		];

		return [
			'data' => $data,
			'meta' => $meta
		];

	}




	public function productDetail($product_data) {
		return [
			'id' => $product_data['id'],
			'title' => $product_data['title'],
			'description' => $product_data['description'],
			'category' => $product_data['category'],
			'tags' => implode(', ', $product_data['tags']),
			'price' => number_format($product_data['price'], 2, ',', '.') . ' €',
			'stock' => $product_data['stock'] == 0 ? 'No stock' : ($product_data['stock'] < 5 ? 'Get it while you can' : 'On Stock'),
			'thumbnail' => $product_data['thumbnail'],
		];
	}
		
}