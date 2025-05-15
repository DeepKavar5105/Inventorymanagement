<?php
namespace App\Controllers;
use App\Models\InventoryLogModel;

class InventoryLogController extends BaseController
{
    public function inventoryLog()
    {
        return view('inventoryLog/inventoryLog');
    }

    public function addInventoryLogForm()
    {
        return view('inventoryLog/addInventoryLog');
    }
}
?>