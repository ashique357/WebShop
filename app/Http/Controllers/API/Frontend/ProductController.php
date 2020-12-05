<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $product;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function getAll(Request $request){
        $products=$this->product->where('status',1)->with(['category:id,name','combinations'=>function($comb){
             $comb->select('id','product_id','sku','available_stock','price as combination_price','discount_price as combination_discount_price','unique_string')
             ->with(['stocks'=>function($stock){
                $stock->select('id','combination_id','total_stock','unit_price','total_price');
             }]);       
            },'productVariations'=>function($prodVar){
                $prodVar->select('id','product_id','name as var_name')
                ->with(['productVariationOptions'=>function($opt){
                    $opt->select('id','product_variation_id','name as var_option_name')->with(['galleries:id,small,medium,large']);
                }]);
            }
        ])->get()->toArray();
        $collection=collect($products);
        
        $display_data=[];
        foreach($collection as $key=>$collect){
            $display_data[$key]['product_id']=$collect['id'];
            $display_data[$key]['name']=$collect['name'];
            $display_data[$key]['slug']=$collect['slug'];
            $display_data[$key]['price']=$collect['price'];
            $display_data[$key]['discount_price']=$collect['discount_price'];
            $display_data[$key]['is_featured']=$collect['is_featured'];
            $display_data[$key]['is_top_seller']=$collect['is_top_seller'];
            $display_data[$key]['is_new']=$collect['is_new'];
            $display_data[$key]['summary']=$collect['summary'];
            $display_data[$key]['description']=$collect['description'];
            $display_data[$key]['preview_image']=$collect['preview_image'];
            $display_data[$key]['status']=$collect['status'];
            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $combinations=$collect['combinations'];
            
            foreach($combinations as $index=>$combination){
                $display_data[$key]['combination'][$index]['id']=$combination['id'];
                $display_data[$key]['combination'][$index]['sku']=$combination['sku'];
                $display_data[$key]['combination'][$index]['available_stock']=$combination['available_stock'];
                $display_data[$key]['combination'][$index]['combination_price']=$combination['combination_price'];
                $display_data[$key]['combination'][$index]['combination_discount_price']=$combination['combination_discount_price'];
                $display_data[$key]['combination'][$index]['unique_string']=$combination['unique_string'];
                
                foreach($combination['stocks'] as $index1=>$c){
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['stock_id']=$c['id'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['total_price']=$c['total_price'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['unit_price']=$c['unit_price'];
                }
            }

            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $variations=$collect['product_variations'];
            
            foreach($variations as $index2=>$variation){

                $display_data[$key]['variation'][$index2]['variation_id']=$variation['id'];
                $display_data[$key]['variation'][$index2]['variation_name']=$variation['var_name'];
                $var_options=$variation['product_variation_options'];
                
                foreach($var_options as $index3=>$var_option){

                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_id']=$var_option['id'];
                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_name']=$var_option['var_option_name'];

                    $galleries=$var_option['galleries'];
                    foreach($galleries as $index4=>$gallery){
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['gallery_id']=$gallery['id'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['small']=$gallery['small'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['medium']=$gallery['medium'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['large']=$gallery['large'];
                    }

                }
            }
        }
        // dd($display_data);
        return response()->json(['display_data'=>$display_data]);
    }

    public function getByFeature(Request $request){
        $products=$this->product->where('status',1)->where('is_featured',1)->with(['category:id,name','combinations'=>function($comb){
             $comb->select('id','product_id','sku','available_stock','price as combination_price','discount_price as combination_discount_price','unique_string')
             ->with(['stocks'=>function($stock){
                $stock->select('id','combination_id','total_stock','unit_price','total_price');
             }]);       
            },'productVariations'=>function($prodVar){
                $prodVar->select('id','product_id','name as var_name')
                ->with(['productVariationOptions'=>function($opt){
                    $opt->select('id','product_variation_id','name as var_option_name')->with(['galleries:id,small,medium,large']);
                }]);
            }
        ])->get()->toArray();
        $collection=collect($products);
        
        $display_data=[];
        foreach($collection as $key=>$collect){
            $display_data[$key]['product_id']=$collect['id'];
            $display_data[$key]['name']=$collect['name'];
            $display_data[$key]['slug']=$collect['slug'];
            $display_data[$key]['price']=$collect['price'];
            $display_data[$key]['discount_price']=$collect['discount_price'];
            $display_data[$key]['is_featured']=$collect['is_featured'];
            $display_data[$key]['is_top_seller']=$collect['is_top_seller'];
            $display_data[$key]['is_new']=$collect['is_new'];
            $display_data[$key]['summary']=$collect['summary'];
            $display_data[$key]['description']=$collect['description'];
            $display_data[$key]['preview_image']=$collect['preview_image'];
            $display_data[$key]['status']=$collect['status'];
            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $combinations=$collect['combinations'];
            
            foreach($combinations as $index=>$combination){
                $display_data[$key]['combination'][$index]['id']=$combination['id'];
                $display_data[$key]['combination'][$index]['sku']=$combination['sku'];
                $display_data[$key]['combination'][$index]['available_stock']=$combination['available_stock'];
                $display_data[$key]['combination'][$index]['combination_price']=$combination['combination_price'];
                $display_data[$key]['combination'][$index]['combination_discount_price']=$combination['combination_discount_price'];
                $display_data[$key]['combination'][$index]['unique_string']=$combination['unique_string'];
                
                foreach($combination['stocks'] as $index1=>$c){
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['stock_id']=$c['id'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['total_price']=$c['total_price'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['unit_price']=$c['unit_price'];
                }
            }

            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $variations=$collect['product_variations'];
            
            foreach($variations as $index2=>$variation){

                $display_data[$key]['variation'][$index2]['variation_id']=$variation['id'];
                $display_data[$key]['variation'][$index2]['variation_name']=$variation['var_name'];
                $var_options=$variation['product_variation_options'];
                
                foreach($var_options as $index3=>$var_option){

                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_id']=$var_option['id'];
                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_name']=$var_option['var_option_name'];

                    $galleries=$var_option['galleries'];
                    foreach($galleries as $index4=>$gallery){
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['gallery_id']=$gallery['id'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['small']=$gallery['small'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['medium']=$gallery['medium'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['large']=$gallery['large'];
                    }

                }
            }
        }
        // dd($display_data);
        return response()->json(['display_data'=>$display_data]);
    }

    public function getByTopSell(Request $request){
        $products=$this->product->where('status',1)->where('is_top_seller',1)->with(['category:id,name','combinations'=>function($comb){
             $comb->select('id','product_id','sku','available_stock','price as combination_price','discount_price as combination_discount_price','unique_string')
             ->with(['stocks'=>function($stock){
                $stock->select('id','combination_id','total_stock','unit_price','total_price');
             }]);       
            },'productVariations'=>function($prodVar){
                $prodVar->select('id','product_id','name as var_name')
                ->with(['productVariationOptions'=>function($opt){
                    $opt->select('id','product_variation_id','name as var_option_name')->with(['galleries:id,small,medium,large']);
                }]);
            }
        ])->get()->toArray();
        $collection=collect($products);
        
        $display_data=[];
        foreach($collection as $key=>$collect){
            $display_data[$key]['product_id']=$collect['id'];
            $display_data[$key]['name']=$collect['name'];
            $display_data[$key]['slug']=$collect['slug'];
            $display_data[$key]['price']=$collect['price'];
            $display_data[$key]['discount_price']=$collect['discount_price'];
            $display_data[$key]['is_featured']=$collect['is_featured'];
            $display_data[$key]['is_top_seller']=$collect['is_top_seller'];
            $display_data[$key]['is_new']=$collect['is_new'];
            $display_data[$key]['summary']=$collect['summary'];
            $display_data[$key]['description']=$collect['description'];
            $display_data[$key]['preview_image']=$collect['preview_image'];
            $display_data[$key]['status']=$collect['status'];
            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $combinations=$collect['combinations'];
            
            foreach($combinations as $index=>$combination){
                $display_data[$key]['combination'][$index]['id']=$combination['id'];
                $display_data[$key]['combination'][$index]['sku']=$combination['sku'];
                $display_data[$key]['combination'][$index]['available_stock']=$combination['available_stock'];
                $display_data[$key]['combination'][$index]['combination_price']=$combination['combination_price'];
                $display_data[$key]['combination'][$index]['combination_discount_price']=$combination['combination_discount_price'];
                $display_data[$key]['combination'][$index]['unique_string']=$combination['unique_string'];
                
                foreach($combination['stocks'] as $index1=>$c){
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['stock_id']=$c['id'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['total_price']=$c['total_price'];
                    $display_data[$key]['combination'][$index]['stocks'][$index1]['unit_price']=$c['unit_price'];
                }
            }

            $display_data[$key]['category_id']=$collect['category']['id'];
            $display_data[$key]['category_name']=$collect['category']['name'];
            $variations=$collect['product_variations'];
            
            foreach($variations as $index2=>$variation){

                $display_data[$key]['variation'][$index2]['variation_id']=$variation['id'];
                $display_data[$key]['variation'][$index2]['variation_name']=$variation['var_name'];
                $var_options=$variation['product_variation_options'];
                
                foreach($var_options as $index3=>$var_option){

                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_id']=$var_option['id'];
                    $display_data[$key]['variation'][$index2]['options'][$index3]['option_name']=$var_option['var_option_name'];

                    $galleries=$var_option['galleries'];
                    foreach($galleries as $index4=>$gallery){
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['gallery_id']=$gallery['id'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['small']=$gallery['small'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['medium']=$gallery['medium'];
                        $display_data[$key]['variation'][$index2]['options'][$index3]['galleries'][$index4]['large']=$gallery['large'];
                    }

                }
            }
        }
        // dd($display_data);
        return response()->json(['display_data'=>$display_data]);
    }

    public function getById(Request $request){
        $product_id=$request->input('product_id');
        $products=$this->product->where('id',$product_id)->with(['category:id,name','combinations'=>function($comb){
             $comb->select('id','product_id','sku','available_stock','price as combination_price','discount_price as combination_discount_price','unique_string')
             ->with(['stocks'=>function($stock){
                $stock->select('id','combination_id','total_stock','unit_price','total_price');
             }]);       
            },'productVariations'=>function($prodVar){
                $prodVar->select('id','product_id','name as var_name')
                ->with(['productVariationOptions'=>function($opt){
                    $opt->select('id','product_variation_id','name as var_option_name')->with(['galleries:id,small,medium,large']);
                }]);
            }
        ])->first()->toArray();
        $collect=collect($products);
        
        $display_data=[];

        $display_data['product_id']=$collect['id'];
        $display_data['name']=$collect['name'];
        $display_data['slug']=$collect['slug'];
        $display_data['price']=$collect['price'];
        $display_data['discount_price']=$collect['discount_price'];
        $display_data['is_featured']=$collect['is_featured'];
        $display_data['is_top_seller']=$collect['is_top_seller'];
        $display_data['is_new']=$collect['is_new'];
        $display_data['summary']=$collect['summary'];
        $display_data['description']=$collect['description'];
        $display_data['preview_image']=$collect['preview_image'];
        $display_data['status']=$collect['status'];
        $display_data['category_id']=$collect['category']['id'];
        $display_data['category_name']=$collect['category']['name'];
        $combinations=$collect['combinations'];
        
        foreach($combinations as $index=>$combination){
            $display_data['combination'][$index]['id']=$combination['id'];
            $display_data['combination'][$index]['sku']=$combination['sku'];
            $display_data['combination'][$index]['available_stock']=$combination['available_stock'];
            $display_data['combination'][$index]['combination_price']=$combination['combination_price'];
            $display_data['combination'][$index]['combination_discount_price']=$combination['combination_discount_price'];
            $display_data['combination'][$index]['unique_string']=$combination['unique_string'];
            
            foreach($combination['stocks'] as $index1=>$c){
                $display_data['combination'][$index]['stocks'][$index1]['stock_id']=$c['id'];
                $display_data['combination'][$index]['stocks'][$index1]['total_price']=$c['total_price'];
                $display_data['combination'][$index]['stocks'][$index1]['unit_price']=$c['unit_price'];
            }
        }

        $display_data['category_id']=$collect['category']['id'];
        $display_data['category_name']=$collect['category']['name'];
        $variations=$collect['product_variations'];
        
        foreach($variations as $index2=>$variation){

            $display_data['variation'][$index2]['variation_id']=$variation['id'];
            $display_data['variation'][$index2]['variation_name']=$variation['var_name'];
            $var_options=$variation['product_variation_options'];
            
            foreach($var_options as $index3=>$var_option){

                $display_data['variation'][$index2]['options'][$index3]['option_id']=$var_option['id'];
                $display_data['variation'][$index2]['options'][$index3]['option_name']=$var_option['var_option_name'];

                $galleries=$var_option['galleries'];
                foreach($galleries as $index4=>$gallery){
                    $display_data['variation'][$index2]['options'][$index3]['galleries'][$index4]['gallery_id']=$gallery['id'];
                    $display_data['variation'][$index2]['options'][$index3]['galleries'][$index4]['small']=$gallery['small'];
                    $display_data['variation'][$index2]['options'][$index3]['galleries'][$index4]['medium']=$gallery['medium'];
                    $display_data['variation'][$index2]['options'][$index3]['galleries'][$index4]['large']=$gallery['large'];
                }

            }
        }

        return response()->json(['display_data'=>$display_data]);
    }
}
