<?php

namespace App\Http\Controllers\master\categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Categories extends Controller
{
  public function index()
  {
    return view('content.master.categories.index');
  }
  public function store(Request $request)
  {
    $categoryName = ucwords(strtolower($request->input('categoryName')));
    $categoryId = $request->input('categoryId');
    $categoryIcon = $request->input('iconThumbnail') ?? null;

    $message = null;
    $payload = null;
    if ($categoryId == null) {
      // add
      $payload = [
        'category_name' => $categoryName,
        'category_icon' => $categoryIcon,
        'soft_delete' => 0,
      ];
      $message = 'New Category Added';
    } else {
      //update

      $payload = [
        'category_id' => $categoryId,
        'category_name' => $categoryName,
        'category_icon' => $categoryIcon,
        'soft_delete' => 0,
      ];
      $message = 'Edit Category Success';
    }

    $data = RequestURI('POST', env('API_URL') . '/categories/store', $payload);

    if ($data->success) {
      return redirect('/master-categories')->with('success', $message);
    } else {
      return redirect('/master-categories')->with('error', $data->errors);
    }
  }
  public function delete()
  {
    return redirect('/master-categories')->with('success', 'Delete Category Success');
  }
}
