<?php

namespace App\Controllers;
use App\Models\Fiscal;
use Support\BaseController;
use Support\DataTables;
use Support\Request;
use Support\Validator;
use Support\View;
use Support\CSRFToken;

class FiscalController extends BaseController
{
    public function getFiscal(Request $request)
    {
        if(Request::isAjax()){
            $fiscal = Fiscal::all();
            return DataTables::of($fiscal)->make(true);
        }
    }
    public function index()
    {
        $title = 'Fiscal';
        return view('fiscal/fiscal',['title'=>$title],'layout/app');
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
