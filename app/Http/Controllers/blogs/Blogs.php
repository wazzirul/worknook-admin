<?php

namespace App\Http\Controllers\blogs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

class Blogs extends Controller
{
    public function index()
    {
        $data = RequestURI('POST', env('API_URL') . '/blog-categories/show');

        if ($data->success) {
            return view('content.blogs.index', compact('data'));
        } else {
            return redirect('/blogs')->with("error", $data->errors);
        }
    }
    public function details($slug)
    {
        $payloadBlog['blog_id'] = $slug;

        $dataBlog = RequestURI('POST', env('API_URL') . '/blog/show', $payloadBlog);
        $data = RequestURI('POST', env('API_URL') . '/blog-categories/show');

        // dd($dataBlog);

        if ($dataBlog->success && $data->success) {
            return view('content.blogs.details', compact('dataBlog', 'data'));
        } else {
            return redirect('/blogs')->with("error", $dataBlog->errors);
        }
    }
    public function store(Request $request)
    {
        $thumbnailEncode = $request->input('thumbnailEncode');
        $blogTitleAdd = $request->input('blogTitleAdd');
        $blogCategoryAdd = $request->input('blogCategoryAdd');
        $blogContent = $request->input('blogContent');
        $blogShortContent = $request->input('blogShortContent');
        $blogFeaturedAdd = $request->input('blogFeaturedAdd');

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($blogContent);

        $payload = [
            'admin_id' =>  session()->get('id'),
            'blog_title' => $blogTitleAdd,
            'blog_thumbnail' => $thumbnailEncode,
            'category_id' => $blogCategoryAdd,
            'description' => $sanitizedContent,
            'short_description' => $blogShortContent,
            'featured' => $blogFeaturedAdd,
            'soft_delete' => null
        ];

        $data = RequestURI('POST', env('API_URL') . '/blog/store', $payload);

        if ($data->success) {
            return redirect('/blogs')->with("success", "New Blog Added");
        } else {
            return redirect('/blogs')->with("error", $data->errors);
        }
    }

    public function delete()
    {
        return redirect('/blogs')->with("success", "Blog Delete Success");
    }

    public function update(Request $request)
    {
        $blog_id = $request->input('blogId');
        $thumbnailEncode = $request->input('thumbnailEncode');
        $blogTitleEdit = $request->input('blogTitleEdit');
        $blogCategoryEdit = $request->input('blogCategoryEdit');
        $blogContent = $request->input('blogContent');
        $blogShortContent = $request->input('blogShortContent');
        $blogFeaturedEdit = $request->input('blogFeaturedEdit');

        // Configure HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitizedContent = $purifier->purify($blogContent);

        $payload = [
            'admin_id' =>  session()->get('id'),
            'blog_id' => $blog_id,
            'blog_title' => $blogTitleEdit,
            'blog_thumbnail' => $thumbnailEncode ? $thumbnailEncode : null,
            'category_id' => $blogCategoryEdit,
            'description' => $sanitizedContent,
            'short_description' => $blogShortContent,
            'featured' => $blogFeaturedEdit,
            'soft_delete' => null
        ];

        // dd($payload);

        $data = RequestURI('POST', env('API_URL') . '/blog/store', $payload);

        if ($data->success) {
            return redirect('/blogs')->with("success", "Blog Updated");
        } else {
            return redirect('/blogs')->with("error", $data->errors);
        }
    }
}
