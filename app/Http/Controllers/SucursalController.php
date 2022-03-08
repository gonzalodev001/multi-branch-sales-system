<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sucursale;

class SucursalController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $sucursales = Sucursale::OrderBy('id', 'desc')->paginate(3);
        
        
        return [
            'pagination' => [
                'total'         => $sucursales->total(),
                'current_page'  => $sucursales->currentPage(),
                'per_page'      => $sucursales->perPage(),
                'last_page'     => $sucursales->lastPage(),
                'from'          => $sucursales->firstItem(),
                'to'            => $sucursales->lastItem(),
            ],
            'sucursales' => $sucursales
        ];
    }

    public function selectSucursal(Request $request){
        if(!$request->ajax()) return redirect('/');

        $sucursales = Sucursale::select('id','nombre')->orderBy('nombre','asc')->get();

        return ['sucursales' => $sucursales];
    }
}
