<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
//    public function __construct(){
//        $this->middleware(["auth"]);
//    }

    public function list(Request $request){

        $search = $request->get("search");
        $category_id = $request->get("category_id");
        $minprice = $request->get("minprice");
        $maxprice = $request->get("maxprice");

        $data = Product::CategoryFiler($category_id)->Search($search)->MinPrice($minprice)->MaxPrice($maxprice)
            ->orderBy("id","desc")->paginate(20);

        $categories = Category::all();
        return view("admin.product.list_product",compact("data",'categories'));
    }
    public function list2(){
//      $data = Product::all();   // select * from product
//      $data = Product::limit(20)->orderBy("id", "asc")->get();

        $data = Product::orderBy("id" , "desc")->paginate(20); //danh sách có phân trang
        return view("admin.product.list_product", compact('data'));

//      return view("admin.product.list_product",[
//          "data"=>$data
//      ]);
    }
    public function create(){
        $categories = Category::all();
        return view("admin.product.add_product" , compact('categories'));
    }

    public function store(Request $request){
        $request->validate([
            "name"=>"required|string|min:6",
            "price"=>"required|numeric|min:0",
            "quantity"=>"required|numeric|min:0",
            "thumbnail"=>"nullable|image|mimes:png,gif,jpg,jpeg"
        ],[
            "queried"=>"Vui lòng nhập thông tin",
            "numeric"=>"Vui lòng nhập số",
            "min"=>"Giá trị của :attribute tối thiểu là :min"
        ]);
        // nhan data tu form của add_product
        $data = $request->except("thumbnail");

        //upload file
        try {
            if ($request->hasFile("thumbnail")){
                $file = $request->file("thumbnail");
                $fileName = time().$file->getClientOriginalName();
                $path = public_path("uploads");
                $file->move($path,$fileName);
                $data["thumbnail"] = "/uploads/".$fileName;
            }
        } catch (\Exception $e){
        } finally {
            $data["thumbnail"] = isset($data["thumbnail"])?$data["thumbnail"]:null;
        }

        Product::create($data);
        return redirect()->to("/admin/product/list_product");
    }


    public function edit(Product $product) {
//        $product = Product::find($id);
//        if ($product == null) {
//            abort(404);
//        }

//        $product = Product::findOrFail($id); // tương đương với if-else ở trên

        $categories = Category::all();
        return view("admin.product.edit_product", compact('categories','product'));
    }

    public function update(Product $product,Request $request){
        $request->validate([
            "name"=>"required|string|min:6",
            "price"=>"required|numeric|min:0",
            "quantity"=>"required|numeric|min:0",
            "thumbnail"=>"nullable|image|mimes:png,gif,jpg,jpeg"
        ],[
            "queried"=>"Vui lòng nhập thông tin",
            "numeric"=>"Vui lòng nhập số",
            "min"=>"Giá trị của :attribute tối thiểu là :min"
        ]);
        // nhan data tu form của add_product
        $data = $request->except("thumbnail");

        //upload file
        try {
            if ($request->hasFile("thumbnail")){
                $file = $request->file("thumbnail");
                $fileName = time().$file->getClientOriginalName();
                $path = public_path("uploads");
                $file->move($path,$fileName);
                $data["thumbnail"] = "/uploads/".$fileName;
            }
        } catch (\Exception $e){
        } finally {
            $data["thumbnail"] = isset($data["thumbnail"])?$data["thumbnail"]:$product->thumbnail;
        }

        $product->update($data);
        return redirect()->to("/admin/product/list_product");
    }

    public function delete(Product $product){
        $product->delete();
        return redirect()->to("/admin/product/list_product");
    }
}
