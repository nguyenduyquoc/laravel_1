<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use function Illuminate\Events\queueable;

class CategoryController extends Controller
{

    public function list(Request $request){

        $search = $request->get("search");
        $data_categories = Category::Search($search)->orderBy("id", "desc")->paginate(20); // danh sách có phân trang

        return view("/admin/category/list_category", compact('data_categories'));
    }


    public function create(){
        return view("/admin/category/add_category");
    }

    public function store(Request $request){
        $request->validate([
            "name"=>"required|string|min:6",
            "icon"=>"nullable|image|mimes:png,gif,jpg,jpeg"
        ],[
            "queried"=>"Vui lòng nhập thông tin",
            "min"=>"Giá trị của :attribute tối thiểu là :min"
        ]);
        // nhan data tu form của add_product
        $data_category = $request->except("icon");
        try {
            if ($request->hasFile("icon")){
                $file = $request->file("icon");
                $fileName = time().$file->getClientOriginalName();
                $path = public_path("uploads");
                $file->move($path,$fileName);
                $data_category["icon"] = "/uploads/".$fileName;
            }
        } catch (\Exception $e){
        } finally {
            $data_category["icon"] = isset($data_category["icon"])?$data_category["icon"]:null;
        }
        Category::create($data_category);
        return redirect()->to("/admin/category/list_category");


    }

    public function edit(Category $category){
        return view("/admin/category/edit_category", compact('category'));
    }

    public function update(Category $category, Request $request){
        $request->validate([
            "name"=>"required|string|min:6",
            "icon"=>"nullable|image|mimes:png,gif,jpg,jpeg"
        ],[
            "queried"=>"Vui lòng nhập thông tin",
            "min"=>"Giá trị của :attribute tối thiểu là :min"
        ]);
        // nhan data tu form của add_product
        $data_category = $request->except("icon");
        try {
            if ($request->hasFile("icon")){
                $file = $request->file("icon");
                $fileName = time().$file->getClientOriginalName();
                $path = public_path("uploads");
                $file->move($path,$fileName);
                $data_category["icon"] = "/uploads/".$fileName;
            }
        } catch (\Exception $e){
        } finally {
            $data_category["icon"] = isset($data_category["icon"])?$data_category["icon"]:$category->icon;
        }
        $category->update($data_category);
        return redirect()->to("/admin/category/list_category");


    }

    public function delete(Category $category){
        $category->delete();
        return redirect()->to("/admin/category/list_category");
    }

}
