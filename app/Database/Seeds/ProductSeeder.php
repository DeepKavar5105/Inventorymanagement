<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Fetch all store IDs
        $storeIds = $this->db->table('stores')->select('store_id')->get()->getResultArray();
        $storeIds = array_column($storeIds, 'store_id');

        // Fetch category IDs by category name
        $categoryNames = ['MobilePhones', 'Laptops', 'Tv', 'freeze'];
        $categoryIds = [];

        foreach ($categoryNames as $name) {
            $category = $this->db->table('categorys')
                ->select('cat_id')
                ->where('catName', $name) // Adjust if column name differs
                ->get()
                ->getRow();

            if ($category) {
                $categoryIds[$name] = $category->cat_id;
            }
        }

        // Only 2 product names per category
        $productsByCategory = [
            'MobilePhones' => ['iPhone 13 Pro', 'Samsung Galaxy S21'],
            'Laptops'      => ['MacBook Air M2', 'Dell XPS 13'],
            'Tv'           => ['Samsung QLED 4K', 'LG OLED CX'],
            'freeze'       => ['LG Double Door', 'Samsung Smart Fridge']
        ];

        $productBuilder = $this->db->table('products');
        $productImageBuilder = $this->db->table('productsimages');

        foreach ($storeIds as $storeId) {
            foreach ($productsByCategory as $categoryName => $productNames) {
                if (!isset($categoryIds[$categoryName])) continue;

                $categoryId = $categoryIds[$categoryName];

                foreach ($productNames as $index => $productName) {
                    $sku     = strtolower(str_replace(' ', '_', explode(' ', $productName)[0]));
                    $barcode = '1000000000' . $index . rand(10, 99);

                    $productBuilder->insert([
                        'storeId'          => $storeId,
                        'categoryId'       => $categoryId,
                        'productName'      => $productName,
                        'sku'              => $sku,
                        'barcode'          => $barcode,
                        'quantity'         => 100,
                        'blocked_quantity' => 0,
                        'damage_quantity'  => 0,
                        'productImage'     => 'product.jpg',
                        'status'           => 'active',
                        'created_By'       => 1,
                        'updated_By'       => 1,
                        'deleted_by'       => null,
                        'created_at'       => Time::now(),
                        'updated_at'       => Time::now(),
                        'deleted_at'       => null,
                    ]);

                    $productId = $this->db->insertID();

                    $productImageBuilder->insert([
                        'storeId'           => $storeId,
                        'productId'         => $productId,
                        'availableQuantity' => 100,
                        'blockedQuantity'   => 0,
                        'status'            => 'active',
                        'created_at'        => Time::now(),
                        'updated_at'        => Time::now(),
                        'deleted_at'        => null,
                    ]);
                }
            }
        }
    }
}
