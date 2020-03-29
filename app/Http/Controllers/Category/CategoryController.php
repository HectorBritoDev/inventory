<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Traits\ApiResponser;

class CategoryController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    public function store(StoreCategory $request)
    {
        $category = Category::create($request->validated());
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategory $request, Category $category)
    {
        $category->fill($request->validated());

        if ($category->isClean()) {
            return $this->errorResponse('at least one value to update must be different', 422);
        }
        $category->save();
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse([]);
    }
}
