<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariationOption;

class VariationOptionController extends Controller
{
    protected $option;
    public function __construct(VariationOption $option){
        $this->option=$option;
    }

    public function index(Request $request){
        if ( $request->input('showdata') ) {
            return $this->option->with('variations')->latest()->get();
            }
            $columns = ['name','var_id'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $filter_input=$request->input('status');
            $query = $this->option->select('name','var_id')->orderBy($column);
            if (isset($search_input)) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%');
                })
                // ->where(function($query) use ($filter_input){
                //     $query->where('status', 'like', '%'.$filter_input.'%');
                // })
                ;
                }
            $option = $query->paginate($length);
            return ['data' => $option];            
    }

    public function store(Request $request){
        $option=new $this->option;
        $option->name=$request->input('name');
        $option->var_id=$request->input('var_id');
        $option->save();
        return response()->json('successfully saved',200);            
    }

    public function update(Request $request){
        if($request->has('id')){
            $option=$this->option->where('id',$request->input('id'))->first();
            $option->name=$request->input('name');
            $option->var_id=$request->input('var_id');
            $option->update();
            return response()->json('successfully updated',200);            
        }
        else{
            return response()->json('error',100);
        }
    }
}
