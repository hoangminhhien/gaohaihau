<?php
namespace App\Repositories\Category;
use App\Models\Category;
use Repository;

class CategoryRepository extends Repository implements CategoryInterface
{
    function __construct(Category $categoryModel)
    {
        $this->model = $categoryModel;
    }
    public function getCategoriesList(){
        $query = $this->model->with('children', 'parent')->select('*')->orderBy('sequence', 'DESC')->get();
        return $query;
    }

    public function createCategories($allParams){
        $category = array();
        $allParams['sequence'] = $this->model->max('sequence')+1;
        $category['name'] = $allParams['name'];
        $category['slug'] = $allParams['slug']; 
        $category['sequence'] = $allParams['sequence'];
        if($allParams['parent_category'] != config('common.default')){
            $category['parent_id'] = $allParams['parent_category'];
        }
        if(!empty($allParams['is_public'])) {
            $category['is_public'] = $allParams['is_public'];
        }
        $result = $this->create($category);

        return $result;
    }

    public function updateCategories($allParams){
        $category = array();
        $category['id'] = $allParams['id'];
        $category['name'] = $allParams['name'];
        $category['slug'] = $allParams['slug'];
        if($allParams['parent_category'] != config('common.default')){ 
            $category['parent_id'] = $allParams['parent_category'];
        }
        if(empty($allParams['is_public'])) {
            $category['is_public'] = config('common.public_default');
        }else{   
            $category['is_public'] = $allParams['is_public'];
        }    
        $result = $this->model->where('id', $category['id'])->update($category);
        return $result;
    }
    
    function getProductGroupByCategoryList($input = [], $product_input = []) {
        $category_list = $this->model->where($input)->with(['products' => function($query) use ($product_input) {
            $query->where($product_input);
        }]);
        return $category_list;
    }
}