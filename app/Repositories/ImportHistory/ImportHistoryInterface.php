<?php
namespace App\Repositories\ImportHistory;

interface ImportHistoryInterface
{
    /**
     * Get import history
     * @param  array  $input query
     * @return [type]        import history list
     */
    public function getImportHistoryList($input = []);

    /**
     * Import inventory, update product quantity, create import history
     * @param  array  $input [description]
     * @return [type]        [description]
     */
    public function importInventory($input = []);

    /**
     * Delete inventory, decreate product quantity
     * @param  [type] $id inventory id
     * @return [type]     [description]
     */
    public function deleteInventory($id = null);
}