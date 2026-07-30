<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->getActiveCategories();

        return response()->json([
            'message' => 'تم جلب التصنيفات بنجاح',
            'data'    => $categories,
        ]);
    }
}
