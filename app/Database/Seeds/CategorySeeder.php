<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Get all store IDs
        $storeIds = $this->db->table('stores')->select('store_id')->get()->getResultArray();
        $storeIds = array_column($storeIds, 'store_id');

        // Base category names
        $baseCategories = ["MobilePhones", "Laptops", "Tv", "freeze"];

        $data = [];

        foreach ($storeIds as $storeId) {
            foreach ($baseCategories as $catName) {
                $data[] = [
                    'storeId'    => $storeId,
                    'catName'    => $catName,
                    'status'     => 'active',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'deleted_by' => null,
                    'created_at' => Time::now(),
                    'updated_at' => Time::now(),
                    'deleted_at' => null,
                ];
            }
        }

        // Insert all at once
        $this->db->table('categorys')->insertBatch($data);
    }
}
