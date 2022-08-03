<?php

namespace App\Http\Controllers\Frontend;

use COM;
use App\Models\Slider;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index(){

        $sliders = Slider::where('status','0')->get();
        return view('frontend.index',compact('sliders'));
    }

    public function categories(){

        $categories = Category::where('status','0')->get();
        return view('frontend.collections.category.index',compact('categories'));
    }
}
