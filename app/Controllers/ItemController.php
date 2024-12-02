<?php

namespace App\Controllers;
use App\Models\Item;
use Support\BaseController;
use Support\DataTables;
use Support\Date;
use Support\Request;
use Support\Response;
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
