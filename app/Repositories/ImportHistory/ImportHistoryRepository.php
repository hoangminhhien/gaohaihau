<?php
namespace App\Repositories\ImportHistory;
use App\Models\ImportHistory;
use Repository;
use App\Repositories\Product\ProductInterface;

class ImportHistoryRepository extends Repository implements ImportHistoryInterface
{
    function __construct(
        ImportHistory $importHistoryModel,
        ProductInterface $productRepo
    )
    {
        $this->model = $importHistoryModel;
        $this->productRepo = $productRepo;
    }

    public function getImportHistoryList($input = []) {
        $import_history_list = $this->model->select('*')
            ->orderBy('created_at', 'DESC')
            ->with('product')
            ->paginate(config('common.paginateLimit'));

        return $import_history_list;
    }

    public function importInventory($input = []) {

        $update_product_result = $this->productRepo->updateProductQuantity($input['product_id'], $input['quantity']);

        if(!$update_product_result) {
            return false;
        }

        // Create import history list
        $this->create($input);

        return true;
    }

    public function deleteInventory($id = null) {
        $inventory_info = $this->model->where('id', $id)->first();
        if(!$inventory_info) {
            return false;
        }
        
        $update_product_result = $this->productRepo
            ->updateProductQuantity($inventory_info['product_id'], ($inventory_info['quantity'] * -1));

        if(!$update_product_result) {
            return false;
        }

        $this->delete($id);
        return true;
    }
}