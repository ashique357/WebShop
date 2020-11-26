<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variation;

class VariationController extends Controller
{
    protected $variation;
    public function __construct(Variation $variation){
        $this->variation=$variation;
    }

    public function index(Request $request){
        if ( $request->input('showdata') ) {
            return $this->variation->latest()->get();
            }
            $columns = ['name'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $filter_input=$request->input('status');
            $query = $this->variation->select('name')->orderBy($column);
            if (isset($search_input)) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%');
                })
                // ->where(function($query) use ($filter_input){
                //     $query->where('status', 'like', '%'.$filter_input.'%');
                // })
                ;
                }
            $variation = $query->paginate($length);
            return ['data' => $variation];            
    }

    public function store(Request $request){
        $variation=new $this->variation;
        $variation->name=$request->input('name');
        $variation->save();
        return response()->json('successfully saved',200);            
    }

    public function update(Request $request){
        if($request->has('id')){
            $variation=$this->variation->where('id',$request->input('id'))->first();
            $variation->name=$request->input('name');
            $variation->update();
            return response()->json('successfully updated',200);            
        }
        else{
            return response()->json('error',100);
        }
    }

    public function getAllVariations(Request $request){
        if($request){
            $variations=$this->variation->pluck('name','id')->all();
            return response()->json(['success'=>200,'variations'=>$variations]);
        }
    }
}
