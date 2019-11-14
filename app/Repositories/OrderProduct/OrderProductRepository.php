<?php
namespace App\Repositories\OrderProduct;
use App\Models\OrderProduct;
use App\Repositories\Product\ProductInterface;
use Repository;
use Log;

class OrderProductRepository extends Repository implements OrderProductInterface
{
    function __construct(OrderProduct $orderProductModel, ProductInterface $product)
    {
        $this->model = $orderProductModel;
        $this->product = $product;
    }

    public function createorUpdateOrderProduct($data){
        $orderProduct['order_id'] =  $data['order_id'];
        if(isset($data['order_product_id'])){
            foreach ($data['order_product_id'] as $value) {
                $result_delete = $this->model->find($value)->forceDelete();
            }
        }
        foreach ($data['product_id'] as $value) {
            $orderProduct['product_id'] = $value;
            if(empty($data['quantity'][$value])) {
                $data['quantity'][$value] = config('common.product.default_quantity');
            }
            $orderProduct['quantity'] = $data['quantity'][$value];
            $orderProduct['price'] = $data['price'][$value];
            $result_order = $this->model->create($orderProduct);
            if(empty($data['status']) ||
                $data['status'] !== config('common.order.status.CUSTOMER_ORDER'))
            {
                $product = $this->product->updateProductQuantityConfirm($value, $data['quantity'][$value]);
            }
        }
        return $result_order;
    }
}