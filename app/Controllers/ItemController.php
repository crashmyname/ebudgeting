<?php

namespace App\Controllers;
use App\Models\Item;
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

class ItemController extends BaseController
{
    // Controller logic here
    public function getItem(Request $request)
    {
        if(Request::isAjax()){
            $item = Item::all();
            return DataTables::of($item)->make(true);
        }
    }

    public function index()
    {
        $title = 'Item & Price';
        $user = User::query()->leftJoin('menu_access','menu_access.uid','=','users.uid')
        ->where('menu_access.uid','=',Session::user()->uid)
        ->where('menu_access.menu_id','=',4)
        ->where('menu_access.can_view','=',1)
        ->first();
        
        if (!$user) {
            View::error('errors/403');
            return;
        }

        if(!$user && !$user->menu_id == 4 && !$user->can_view == 1){
            View::error('errors/403');
            return;
        }
        return view('item/item',['title'=>$title],'layout/app');
    }

    public function create(Request $request)
    {
        $item = Item::create([
            'uuid' => UUID::generateUuid(),
            'item_name' => $request->item_name,
            'group_item' => $request->group_item,
            'harga' => $request->harga,
            'code_category' => $request->code_category,
            'unit' => $request->unit,
            'validity' => $request->validity
        ]);
        return Response::json(['status'=>200]);
    }

    public function import(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $item = Item::query()->where('uuid','=',$id)->first();
        $item->item_name = $request->item_name;
        $item->group_item = $request->group_item;
        $item->harga = $request->harga;
        $item->code_category = $request->code_category;
        $item->unit = $request->unit;
        $item->validity = $request->validity;
        $item->save();
        return Response::json(['status'=>200]);
    }

    public function delete(Request $request, $id)
    {
        $item = Item::query()->where('uuid','=',$id)->first();
        $item->deleted_at = Date::Now();
        $item->save();
        return Response::json(['status'=>200]);
    }
}
