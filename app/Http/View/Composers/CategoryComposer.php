<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view)
    {
        $view->with('categories', Category::orderBy('name', 'asc')->where('is_parent', 0)->where('status', 0)->get());
    }
}
