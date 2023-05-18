<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufactures;
use App\Models\ProductProtypes;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
         //lấy User từ database
         public function getProduct(Request $request){
            $url = $request->url();
            if(str_contains($url, 'keyword')){
                $request->validate([
                    'keyword' => 'required',
                ]);
                $keyword = $request->input('keyword');
                if($keyword != null){
                    $productList = DB::table('products')
                    ->where('description', 'LIKE', '%'.$keyword.'%')
                    ->paginate(4);
                }
            }
            else{
                $productList = DB::table('products')
                ->join('protypes', 'products.type_id', '=', 'protypes.id')
                ->join('manufactures', 'products.manu_id', '=', 'manufactures.id')
                ->orderBy('products.created_at', 'desc')
                ->select('products.id','products.type_id','protypes.type_name','products.manu_id','manufactures.manu_name','products.description','products.qty',
                'products.created_at','products.price','products.discount','products.name','products.image')
                ->paginate(4);
            }
            return view('admin.product',compact('productList'));
        }
        // //trang m user,..
        public function productadd()
        {
            $manu = Manufactures::all();
            $protype = ProductProtypes::all();
            return view('admin.product_add',compact('manu','protype'));
        }
        public function create(array $data)
        {
            // if(isset($request->input('checkbox_name'))) {
            //     // Nếu được chọn, xử lý thêm dữ liệu vào database
            //     // ...
            // }
          return Product::create([
            'name' => $data['name'],
            'manu_id' => $data['manu_id'],
            'type_id' => $data['type_id'],
            'qty' => $data['qty'],
            'price' => $data['price'],
            'sell_number' => $data['sell_number'] = 0,
            'image' => $data['fileToUpload'],
            'description' => $data['description'],
            'feature' => $data['feature'],
            'discount' => $data['discount'],
          ]);
        }     
        //thêm sản phẩm
        public function AddProduct(Request $request)
        {  
            $request->validate([
                'name' => 'required',
                'description' => 'required'
            ]);
            if($request->hasFile('fileToUpload')){
                $file = $request->file('fileToUpload');
                $filename = $file->getClientOriginalName();
                $file->move('front/img/',$filename);
                // $request->input('image', $filename);
            }
            $data = $request->all();
            $data['feature'] = $request->input('checkboxName') ? 1 : 0;
            $data['fileToUpload'] = $filename;
            $product = $this->create($data);
            return redirect('admin/product')->withSuccess('Thêm Thành công!');
        }
        //update sản phẩm
        public function editproduct($id)
        {
            $manu = Manufactures::all();
            $protype = ProductProtypes::all();
            $product = Product::findOrFail($id);
            return view('admin.product_add',compact('product','manu','protype'));
            
        }  
        public function update(Request $request, $id)
        {
            $product = Product::find($id);
            $product->name = $request->input('name');
            $product -> manu_id = $request->input('manu_id');
            $product -> type_id = $request->input('type_id');
            $product -> qty = $request->input('qty');
            $product -> price = $request->input('price');
            if($request->hasFile('fileToUpload')){
                $file = $request->file('fileToUpload');
                $filename = $file->getClientOriginalName();
                $product -> image = $filename;
                $file->move('front/img/',$filename);
                // $request->input('image', $filename);
            }
            // dd($request->input('fileToUpload'));die();
            $product -> description = $request->input('description');
            $product -> feature = $request->input('checkboxName') ? 1 : 0;
            $product -> discount = $request->input('discount');
            $product->save();
            return redirect('admin/product')->withSuccess('Update Thành công!!');;
        }
    
        public function viewDetailProduct($id){
            $product = Product::find($id);
            //productReviewer lấy trong Models
            $comments = $product->productReviewer;
            return view('admin.product_detail',compact('product','comments'));
        }
         // hàm tìm kiếm
}
