<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Helpers\FileHelper;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Category\CategoryInterface;
class ProductController extends Controller
{
    public function __construct(ProductInterface $product, CategoryInterface $category){
        $this->product = $product;
        $this->category = $category;
    }
    public function index(){
        $products = $this->product->getListProduct();
        $categories = $this->category->getCategoriesList();
        $products = Product::paginate(config('common.product_limit'));
        return view('admin.products.index', compact(['products', 'categories']));
    }

    public function store(ProductRequest $request){
        $data = $request->all();
        $data['category_id']=1;
        $products = $this->product->createProduct($data);
        return redirect()->route('admin.products');
    }
     public function update(ProductRequest $request){
        $input = $request->all();
        $product = Product::where('id', $input['id'])->first();
        // Check product exist
        if(!$product){
            return abort(404);
        }
        if($request->hasFile('image')){
            FileHelper::removeFile($product->image_url);
            $product->image_url = FileHelper::uploadFile($file = $input['image'], null, $base_path = 'uploads/products_image');
        }
        
        if(empty($input['is_public'])) {
            $input['is_public'] = config('common.public_default');
        }
        // Execute update
        $product->image_url = $product->image_url;
        $product->is_public = $input['is_public'];
        $product->save();
        $products = $this->product->updateProduct($input['id'], $input);
        return redirect()->route('admin.products');
    }

    public function delete($id){
        Product::where('id',$id)->delete();
        // Delete file
        FileHelper::removeFileWithPrefix($base_path = 'uploads/products_image', $prefix = $id . '_');
    }
}
