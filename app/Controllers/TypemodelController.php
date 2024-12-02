<?php

namespace App\Controllers;
use App\Models\TypeModel;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class TypemodelController extends BaseController
{
    public function getTypeModel(Request $request)
    {
        if(Request::isAjax()){
            $typemodel = TypeModel::all();
            return DataTables::of($typemodel)->make(true);
        }
    }
    public function index()
    {
        $title = 'Type Model';
        return view('typemodel/typemodel',['title'=>$title],'layout/app');
    }

    public function show($id)
    {
        // Tampilkan resource dengan ID: $id
    }

    public function store(Request $request)
    {
        // Simpan resource baru
    }

    public function update(Request $request, $id)
    {
        // Update resource dengan ID: $id
    }

    public function destroy($id)
    {
        // Hapus resource dengan ID: $id
    }
}
