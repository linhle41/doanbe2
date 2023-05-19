<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StoreController extends Controller
{
    //view store
    public function getProductStore(Request $request){ 
        $productsofSelling = Product::orderBy('sell_number', 'desc')->take(3)->get();
        // dd($productsofSelling);die();
       //Biến
       $total = $request->get('show');
       $sortBy = $request->get('sort_by');
       $price_min = $request->get('price_min') ? $request->get('price_min'):1;
       $price_max = $request->get('price_max') ? $request->get('price_max'):999000;
       $brands = $request-> brand ?? [];
       $brand_id = array_keys($brands);
       $categorys = $request-> category ?? [];
       $category_id = array_keys($categorys);
       $type_id = $request->get('type_id');
        if($request->filled('sort_by') != null){
            $products = $this->getProductOnSortandTypeid($request,$type_id,$total,$sortBy,$price_min,$price_max);
        }else{
            $products = $this->filter($request,$type_id,$category_id,$brand_id,$price_min,$price_max);
            
        }
        return view('frontend.store', compact('products','type_id','productsofSelling'));
    }
    //lấy sản phẩm sắp xếp theo id và show sản phẩm theo giá
    public function getProductOnSortandTypeid(Request $request,$type_id,$total,$sortBy,$price_min,$price_max){
        $products = '';

        switch($sortBy){
            case'lasted':
                $products = Product::when(!empty($type_id), function ($query) use ($type_id) {
                    return $query->where('type_id', $type_id);
                })
                ->orderBy('id', 'asc')
                ->take($total)
                ->paginate(9);
                break;
            case'oldest':
                $products = Product::when(!empty($type_id), function ($query) use ($type_id) {
                    return $query->where('type_id', $type_id);
                })->orderBy('id', 'desc')
                ->take($total)
                ->paginate(9);
                break;
            default:
                $products = Product::when(!empty($type_id), function ($query) use ($type_id) {
                    return $query->where('type_id', $type_id);
                })->whereBetween('price', [$price_min, $price_max* 1000])->orderBy('id', 'asc')->take(20)->paginate(9);
        }
        return  $products;
    }
    //lấy sản phẩm theo hãng , theo giá và phân loại
    public function filter(Request $request,$type_id,$category_id,$brand_id,$price_min,$price_max){
        $products = Product::whereBetween('price', [$price_min, $price_max * 1000])
                ->when(!empty($type_id), function ($query) use ($type_id) {
                    return $query->where('type_id', $type_id);
                })
                ->when($brand_id, function ($query) use ($brand_id) {
                    return $query->whereIn('manu_id', $brand_id);
                })
                ->when($category_id, function ($query) use ($category_id) {
                    return $query->whereIn('type_id', $category_id);
                })
                ->paginate(9);
        return $products;
    }
}
