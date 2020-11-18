<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category){
        $this->category=$category;
    }

    public function index(){
        return view('Backend.Pages.Category.index');
    }

    public function getCategories(Request $request){
        if ( $request->input('showdata') ) {
            return $this->category->latest()->get();
            }
            $columns = ['name', 'slug','status','parent_id','type'];
            $length = $request->input('length');
            $column = $request->input('column');
            $search_input = $request->input('search');
            $query = $this->category->select('name', 'slug','status','parent_id','type')->orderBy($column);
            if ($search_input) {
                $query->where(function($query) use ($search_input) {
                $query->where('name', 'like', '%' . $search_input . '%')
                ->orWhere('slug', 'like', '%' . $search_input . '%')
                ->orWhere('parent_id', 'like', '%' . $search_input . '%')
                ->orWhere('type', 'like', '%' . $search_input . '%')
                ->orWhere('status', 'like', '%' . $search_input . '%');
                });
                }
            $categories = $query->paginate($length);
            return ['data' => $categories];            
    }


    public function updateCategories(Request $request){
        $request->validate([
            'name' => 'required',
            ]);

        if($request->has('id')){
            $category=$this->category->where('id',$request->input('id'))->first();
            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['slug']=str_replace(" ","-",strtolower($input['slug']));
            if($input['parent_id'] != 0){
            $parent=$this->category->getParentId($input['parent_id']);
            $parent->has_child=1;
            $parent->slug=null;
            $parent->save(); 
            }
            $category->update($input);

            return response()->json('successfully updated',200);            
    }
        else{
            return response()->json('error',100);
        }
    }

    public function createCategories(Request $request){
        $request->validate([
            'name' => 'required',
            ]);

            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            $input['slug']=str_replace(" ","-",strtolower($input['slug']));
            if($input['parent_id'] != 0){
                $parent=$this->category->getParentId($input['parent_id']);
                $parent->has_child=1;
                $parent->slug=null;
                $parent->save(); 
            }
            $this->category->create($input);
            
            return response()->json('successfully saved',200);            
    }

    public function getAllCategories(Request $request){
        if($request){
            $categories=$this->category->pluck('name','id','type')->all();
            return response()->json(['success'=>200,'categories'=>$categories]);
        }
    }
}
