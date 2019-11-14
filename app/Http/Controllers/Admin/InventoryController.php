<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ImportHistory\ImportHistoryInterface;
use App\Repositories\Product\ProductInterface;
use App\Http\Requests\InventoryRequest;

class InventoryController extends Controller
{
    function __construct(
        ImportHistoryInterface $importHistoryRepo,
        ProductInterface $productRepo
    ) {
        $this->importHistoryRepo = $importHistoryRepo;
        $this->productRepo = $productRepo;
    }

    public function index(Request $request) {
        $input = $request->input();
        $import_history_list = $this->importHistoryRepo->getImportHistoryList($input);
        $product_selection_list = $this->productRepo->getListProduct();
        return view('admin.inventories.index', compact('import_history_list', 'product_selection_list'));
    }

    public function create(InventoryRequest $request) {
        $input = $request->input();
        $this->importHistoryRepo->importInventory($input);
        session(['submit_success' => 'create']);
        return response()->json();
    }

    public function delete(Request $request, $id) {
        $input = $request->input();
        $this->importHistoryRepo->deleteInventory($id);
        session(['submit_success' => 'delete']);
        return response()->json();
    }
}
