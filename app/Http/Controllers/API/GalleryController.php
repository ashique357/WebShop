<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\HTTP\Traits\HelperTraits;
// use Intervention\Image\ImageManager as Image;
use Image;

class GalleryController extends Controller
{
    use HelperTraits;
    protected $gallery;
    public function __construct(Gallery $gallery){
        $this->gallery=$gallery;
    }

    
    public function index(Request $request){
            $galleries = $this->gallery->latest()->get();
            return response()->json(['galleries'=>$galleries]);            
    }

    public function store(Request $request){
        $fname="files";
        $toStorage="products/images/";
        if($request->hasFile($fname)){   
            foreach($request->file($fname) as $file){
                $filePath=public_path('products/images/');
                $name ='gallery_'.'_'.mt_rand(100,2000).time().'.'.$file->extension();
                $resize1=Image::make($file);
                $small=$resize1->resize(200,200)->save($filePath.'small_'.$name);
                $small=$small->basename;
                
                $resize2=Image::make($file);
                $medium=$resize2->resize(800,800)->save($filePath.'medium_'.$name);
                $medium=$medium->basename;

                $resize3=Image::make($file);
                $large=$resize3->resize(1024,1024)->save($filePath.'large_'.$name);
                $large=$large->basename;
                
                $gallery=new $this->gallery;
                
                $gallery->small='/'.$toStorage.$small;
                $gallery->medium='/'.$toStorage.$medium;
                $gallery->large='/'.$toStorage.$large;

                $gallery->save();
            }
            return response()->json('success',200);
         }
        }


    public function getAll(Request $request){
        if($request){
            $galleries=$this->gallery->latest()->get();
            return response()->json(['success'=>200,'galleries'=>$galleries]);
        }
    }
}
