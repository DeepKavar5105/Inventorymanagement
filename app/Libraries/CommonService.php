<?php
namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\I18n\Time;

class CommonService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function softDelete(string $table, string $primaryKey, $id, $userId)
    {
        return $this->db->table($table)
            ->where($primaryKey, $id)
            ->update([
                'status'     => 0,
                'deleted_by' => $userId,
                'deleted_at' => Time::now('Asia/Kolkata', 'en_US')->toDateTimeString(),
            ]);
    }
}
?>