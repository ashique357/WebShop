<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product){
        $this->product=$product;

        // $this->middleware('can:create,App\Models\Admin')->only('create');
        // $this->middleware('can:update,admin,update')->only('update');
        // $this->middleware('can:delete,user')->only('destroy');
    }

    public function index(Request $request){
        if ( $request->input('showdata') ) {
            return $this->product->with('categories')->latest()->get();
            }
            $columns = ['name', 'slug','category_id','preview_image'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = $this->product->select('name', 'slug','category_id','preview_image')->orderBy($column);
            if (isset($search_input)) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')
                ->orWhere('slug', 'like', '%' . $search_input . '%')
                ->orWhere('category_id', 'like', '%' . $search_input . '%')
                ->orWhere('preview_image', 'like', '%' . $search_input . '%');
                })
                // ->where(function($query) use ($filter_input){
                //     $query->where('status', 'like', '%'.$filter_input.'%');
                // })
                ;
                }
            $products = $query->paginate($length);
            return ['data' => $products];            
    }

    public function store(Request $request){
        $product=new $this->product;
        $product->name=$request->input('name');
        $product->slug=$request->input('slug');
        $product->category_id=$request->input('category_id');
        $product->save();
        return response()->json('successfully saved',200);            
    }

    public function update(Request $request){
        if($request->has('id')){
            $product=$this->product->where('id',$request->input('id'))->first();
            $product->name=$request->input('name');
            $product->slug=$request->input('slug');
            $product->category_id=$request->input('category_id');
            $product->update();
            return response()->json('successfully updated',200);            
        }
        else{
            return response()->json('error',100);
        }
    }
}
