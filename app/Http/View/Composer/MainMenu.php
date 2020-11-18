<?php

namespace App\Http\View\Composer;


use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\View\View;


class MainMenu{

    public function compose(View $view){
        $ca = Category::where('parent_id', '=', 0)->get();   
        $view->with('ca',$ca);
    }
}