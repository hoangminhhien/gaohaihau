<?php
namespace App\Repositories\Product;

interface ProductInterface {
    public function getListProduct();
    /**
     * Update product quantity
     * @param  [type]  $product_id Product ID
     * @param  integer $quantity   Quantity
     * @return [type]              true
     */
    public function createProduct($data);
    public function updateProduct($id, $data);
    public function updateProductQuantity($product_id = null, $quantity);
    public function updateProductQuantityConfirm($product_id = null, $quantity);
    public function getProductByID($id );
    public function getListProductPromotion($gift_code);
}
