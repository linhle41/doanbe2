<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StoreController extends Controller
{
    //view store
    public function getProductStore(Request $request){
       //Biến
       $total = $request->get('show');
       $sortBy = $request->get('sort_by');
       $price_min = $request->get('price_min') ? $request->get('price_min'):1;
       $price_max = $request->get('price_max') ? $request->get('price_max'):999000;
       $type_id = $request->get('type_id');
            $products = $this->getProductOnSortandTypeid($request,$type_id,$total,$sortBy,$price_min,$price_max);
            
        return view('frontend.store', compact('products','type_id'));
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
}
