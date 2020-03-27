<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index()
    {
        return $this->showAll(Category::all());
    }

    public function store(CategoryRequest $request)
    {
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
