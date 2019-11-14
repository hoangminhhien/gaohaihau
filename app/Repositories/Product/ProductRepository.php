<?php
namespace App\Repositories\Product;
use App\Models\Product;
use App\Helpers\FileHelper;
use Repository;

class ProductRepository extends Repository implements ProductInterface
{
    function __construct(Product $productModel)
    {
        $this->model = $productModel;
    }

    public function getListProduct()
    {
    	$product = $this->model->get();
        return $product;
    }
    public function createProduct($data){
        $image_url = '';
        if(isset($data['image'])){
            $image_url = FileHelper::uploadFile($file = $data['image'], null, $base_path = 'uploads/products_image');
        }
        if(empty($data['is_public'])) {
            $data['is_public'] = config('common.public_default');
        }

        if (!empty($data['gift_code'])) {
            $data['gift_code'] = config('common.product.GIFT_CODE.NEWCUS.code'); 
        }
        $product = [];
        $product['category_id'] = 1;
        $product['name'] = $data['name'];
        $product['made_from'] = $data['made_from'] ? $data['made_from'] : '';
        $product['unit'] = $data['unit'];
        $product['capacity'] = $data['capacity'];
        $product['price'] = $data['price'];
        $product['image_url'] = $image_url;
        $product['short_desc'] = $data['short_desc'];
        $product['desc'] = $data['desc'];
        $product['type'] = $data['type'];
        $product['is_public'] = $data['is_public'];
        $product['gift_code'] = $data['gift_code'];
        $result = $this->model->create($product);
        return $result;
    }
    public function updateProduct($id, $data){
        $product = [];
        $product['category_id'] = $data['category'];
        $product['name'] = $data['name'];
        $product['made_from'] = $data['made_from'];
        $product['unit'] = $data['unit'];
        $product['type'] = $data['type'];
        $product['capacity'] = $data['capacity'];
        $product['price'] = $data['price'];
        $product['short_desc'] = $data['short_desc'];
        $product['desc'] = $data['desc'];
        $produc['is_public'] = $data['is_public'];
        $result = $this->model->find($id)->update($product);
    }
    public function updateProductQuantity($product_id = null, $quantity) {
        $product_info = $this->model->where('id', $product_id)->first();

        if(!$product_info) {
            return false;
        }

        $product_info['quantity'] = $product_info['quantity'] + $quantity;
        $this->update(
            $product_id,
            [ 'quantity' => $product_info['quantity'] ]
        );

        return true;
    }

    public function updateProductQuantityConfirm($product_id = null, $quantity) {
        $product_info = $this->model->where('id', $product_id)->first();

        if(!$product_info) {
            return false;
        }

        $product_info['quantity'] = $product_info['quantity'] - $quantity;
        $this->update(
            $product_id,
            [ 'quantity' => $product_info['quantity'] ]
        );

        return true;
    }

    public function getProductByID($id){
        $product_info = $this->model->where('id', $id)->first();
        return $product_info;
    }

    public function getListProductPromotion($gift_code){
        $product = $this->model->where('gift_code',$gift_code)->get();
        return $product;
    }
}