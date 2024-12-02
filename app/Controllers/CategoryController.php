<?php

namespace App\Controllers;
use App\Models\Category;
use App\Models\User;
use Support\BaseController;
use Support\DataTables;
use Support\Date;
use Support\Request;
use Support\Response;
use Support\Session;
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
                        ->select('uuid','code_category','category','group_category','sub','validity','category_id')
                        ->where('deleted_at','=',null)
                        ->orderBy('category_id','asc')
                        ->get();
            return DataTables::of($category)
                    ->make(true);
        }
    }

    public function index()
    {
        $title = 'Category';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',2)
        ->where('menu_access.can_view','=',1)
        ->first();
        
        if (!$user) {
            View::error('errors/403');
            return;
        }

        if(!$user && !$user->menu_id == 2 && !$user->can_view == 1){
            View::error('errors/403');
            return;
        }
        return view('category/category',['title'=>$title],'layout/app');
    }
    
    public function create(Request $request)
    {
        $category = Category::query()->where('code_category','=',$request->code_category)->first();
        if($category){
            Response::json(['status'=>409,'message'=>'Data Yang diinputkan sudah ada']);
        }
        Category::create([
            'uuid' => UUID::generateUuid(),
            'code_category' => $request->code_category,
            'category' => $request->category,
            'group_category' => $request->group,
            'sub' => $request->sub,
            'validity' => $request->validity,
        ]);
        return Response::json(['status'=>200]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::query()->where('uuid','=',$id)->first();
        $category->category = $request->category;
        $category->group_category = $request->group;
        $category->sub = $request->sub;
        $category->validity = $request->validity;
        $category->updated_at = Date::Now();
        $category->save();
        return Response::json(['status'=>200]);
    }

    public function delete(Request $request, $id)
    {
        $category = Category::query()->where('uuid','=',$id)->first();
        $category->deleted_at = Date::Now();
        $category->save();
        return Response::json(['status'=>200]);
    }
}
