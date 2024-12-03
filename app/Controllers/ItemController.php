<?php

namespace App\Controllers;
use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
            $item = Item::query()->where('deleted_at','=',null)->get();
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
        $unit = Unit::query()->select('code_unit','unit')->get();
        $code_category = Category::query()->select('code_category')->get();
        return view('item/item',['title'=>$title,'unit'=>$unit,'code'=>$code_category],'layout/app');
    }

    public function importExcel(Request $request)
    {
        if(!$request->file('file')){
            echo 'File tidak ada';
            return;
        }
        $filepath = $request->file('file');
        try{
            $spreadsheet = IOFactory::load($request->getPath('file'));
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            // Mengabaikan baris pertama (header)
            array_shift($data);
            // Menampilkan data untuk pengecekan (atau simpan ke database)
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            foreach($data as $row){
                // $unit = Unit::query()->where('unit','=',trim($row['D']))->first();
                $item = [
                    'uuid' => UUID::generateUuid(),
                    'item_name' => $row['B'],
                    'group_item' => $row['G'],
                    'harga' => $row['C'],
                    'code_category' => $row['E'],
                    'unit' => $row['D'],
                    'validity' => 1
                ];
                $item = Item::create($item);
            }
            return Response::json(['status'=>200]);
        } catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e){
            echo 'Terjadi kesalahan saat membaca file: ' . $e->getMessage();
        }
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
            'validity' => 1,
        ]);
        return Response::json(['status'=>200]);
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
