<?php

namespace App\Controllers;
use App\Models\Category;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Response;
use Support\UUID;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class CategoryController extends BaseController
{
    // Controller logic here
    public function getCategory(Request $request)
    {
        if(Request::isAjax()){
            $category = Category::query()
                        ->select('uuid','code_category','category','group_category','sub','validity')
                        ->get();
            return DataTables::of($category)
                    ->make(true);
        }
    }

    public function index()
    {
        $title = 'Category';
        return view('category/category',['title'=>$title],'layout/app');
    }
    
    public function create(Request $request)
    {
        $category = Category::create([
            'uuid' => UUID::generateUuid(),
            'code_category' => $request->code_category,
            'category' => $request->category,
            'group_category' => $request->group,
            'sub' => $request->sub,
            'validity' => $request->validity,
        ]);
        return Response::json(['status'=>200]);
    }
}
