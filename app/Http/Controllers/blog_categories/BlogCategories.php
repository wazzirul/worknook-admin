<?php

namespace App\Http\Controllers\blog_categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCategories extends Controller
{
    public function index()
    {
        return view('content.blog-category.index');
    }
    public function store(Request $request){
        $categoryName = ucwords(strtolower($request->input('categoryName')));
        $categoryDesc = $request->input('categoryDesc');
        $categoryId = $request->input('categoryId');

        $message = null;
        $payload = null;
        if($categoryId==null){ // add
            $payload = [
            'category_name' => $categoryName,
            'description' => $categoryDesc,
            'soft_delete' => 0
        ];
            $message = "New Category Added";
        }else{           //update

            $payload = [
                'blog_category_id' => $categoryId,
                'category_name' => $categoryName,
                'description' => $categoryDesc,
                'soft_delete' => 0
            ];
            $message = "Edit Category Success";

        }

        $data = RequestURI('POST', env('API_URL') . '/blog-categories/store', $payload);

        if ($data->success) {
            return redirect('/blog-categories')->with("success", $message);
        } else {
            return redirect('/blog-categories')->with("error", $data->errors);
        }
    }
    public function delete(){
        return redirect('/blog-categories')->with("success", "Delete Category Success");
    }
}
