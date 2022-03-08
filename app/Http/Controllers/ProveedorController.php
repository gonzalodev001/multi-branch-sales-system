<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Proveedor;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $personas = Proveedor::join('personas','proveedores.idp','=','personas.id')
            ->select('personas.id','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email',
            'proveedores.contacto','proveedores.telefono_contacto')
            ->OrderBy('personas.id', 'desc')->paginate(3);
        }else{
            $personas = Proveedor::join('personas','proveedores.idp','=','personas.id')
            ->select('personas.id','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email',
            'proveedores.contacto','proveedores.telefono_contacto')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')->OrderBy('personas.id','desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'         => $personas->total(),
                'current_page'  => $personas->currentPage(),
                'per_page'      => $personas->perPage(),
                'last_page'     => $personas->lastPage(),
                'from'          => $personas->firstItem(),
                'to'            => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->numero_documento = $request->numero_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $proveedor = new Proveedor();
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->idp = $persona->id;
            $proveedor->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollback();
        }

        
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            
            $proveedor = Proveedor::findOrFail($request->idp);

            $persona = Persona::findOrFail($proveedor->idp);

            $persona->nombre = $request->nombre;
            $persona->numero_documento = $request->numero_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            $proveedor->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollback();
        }

    }

    public function selectProveedor(Request $request){
        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $proveedores = Proveedor::join('personas','proveedores.idp','=','personas.id')
        ->where('personas.nombre','like','%'.$filtro.'%')
        ->orWhere('personas.numero_documento','like','%'.$filtro.'%')
        ->select('personas.id','personas.nombre','personas.numero_documento')
        ->orderBy('personas.nombre','asc')->get();

        return ['proveedores' => $proveedores];
    }
}
