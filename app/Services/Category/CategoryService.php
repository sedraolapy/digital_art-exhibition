<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)->get();
    }
}