<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Repository;

class CategoryController extends Controller
{
    public function __construct(
        CategoryInterface $categoryRepo
    ) 
    {
        $this->categoryRepo = $categoryRepo;
    }
    public function index(){
        $categoryLists = $this->categoryRepo->getCategoriesList();
        return view('admin.categories.index', compact('categoryLists'));
    }

    public function store(CategoryRequest $request){
        $allParams = $request->all();
        $category = $this->categoryRepo->createCategories($allParams);
        return response()->json('success');
    }

    public function update(CategoryRequest $request){
        $allParams = $request->all();
        $category = $this->categoryRepo->updateCategories($allParams);
        return response()->json('success');
    }

    public function delete($id){
        $staff = $this->categoryRepo->delete($id);
        return response()->json(['result' => true]);
    }
}
