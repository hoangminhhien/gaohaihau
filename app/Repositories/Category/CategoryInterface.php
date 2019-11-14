<?php
namespace App\Repositories\Category;

interface CategoryInterface
{
    public function getCategoriesList();
    public function createCategories($allParams);
    public function updateCategories($allParams);
    function getProductGroupByCategoryList($input = [], $product_input = []);
}

