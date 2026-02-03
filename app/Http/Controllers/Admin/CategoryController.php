<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('q');

        return Category::where('title', 'like', "%{$search}%")
            ->limit(10)
            ->get()
            ->map(fn ($cat) => [
                'value' => $cat->id,
                'text'  => $cat->title,
            ]);
    }



}