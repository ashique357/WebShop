<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Traits\HelperTraits;

class GalleryController extends Controller
{
    // use HelperTraits;
    protected $gallery;
    public function __construct(Gallery $gallery){
        $this->gallery=$gallery;
    }

    
    public function index(Request $request){
        if ( $request->input('showdata') ) {
            return $this->gallery->latest()->get();
            }
            $columns = ['small', 'medium','large'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = $this->gallery->select('small', 'medium','large')->orderBy($column);
            if ($search_input) {
                $query->where(function($query) use ($search_input) {
                $query->where('small', 'like', '%' . $search_input . '%')
                ->orWhere('medium', 'like', '%' . $search_input . '%')
                ->orWhere('large', 'like', '%' . $search_input . '%');
                });
                }
            $galleries = $query->paginate($length);
            return ['data' => $galleries];            
    }

    public function store(Request $request){
        $fname="files";
        $toStorage="/products/images";
        if($request->hasFile($fname)){   
            foreach($request->file($fname) as $file){
                $name = mt_rand(100,2000).time().'.'.$file->extension();
                $file->move(public_path().$toStorage, $name); 
                
                $gallery=new $this->gallery;
                $gallery->small=$toStorage.'/'.$name;
                $gallery->medium=$toStorage.'/'.$name;
                $gallery->large=$toStorage.'/'.$name;
                
                $gallery->save();
            }
         }
    }

    public function getAll(Request $request){
        if($request){
            $galleries=$this->gallery->latest()->get();
            return response()->json(['success'=>200,'galleries'=>$galleries]);
        }
    }

}
