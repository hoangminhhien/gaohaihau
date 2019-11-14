<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Product\ProductInterface;
use App\Repositories\Category\CategoryInterface;

class HomeController extends Controller
{
    function __construct(
        ProductInterface $productRepo,
        CategoryInterface $categoryRepo
    )
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request) {

        $category_input = array(
            'is_public' => config('common.category.IS_PUBLIC.ACTIVE')
        );

        $product_input = array(
            'is_public' => config('common.product.IS_PUBLIC.ACTIVE')
        );
        $category_list = $this->categoryRepo
            ->getProductGroupByCategoryList($category_input, $product_input)
            ->orderBy('sequence')
            ->get();

        return view('web.home.index', compact('category_list'));
    }
}
