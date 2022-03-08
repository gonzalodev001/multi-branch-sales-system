<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $clientes = Cliente::join('personas','clientes.idpersona','=','personas.id')
            ->select('clientes.id','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email')
            ->OrderBy('clientes.id', 'desc')->paginate(3);
        }else{
            $clientes = Cliente::join('personas','clientes.idpersona','=','personas.id')
            ->select('clientes.id','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')->OrderBy('clientes.id','desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'         => $clientes->total(),
                'current_page'  => $clientes->currentPage(),
                'per_page'      => $clientes->perPage(),
                'last_page'     => $clientes->lastPage(),
                'from'          => $clientes->firstItem(),
                'to'            => $clientes->lastItem(),
            ],
            'clientes' => $clientes
        ];
    }

    public function store(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->numero_documento = $request->numero_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            //dump($persona);
            $persona->save();

            $cliente = new Cliente();
            $cliente->idpersona = $persona->id;
            $cliente->nota_corta = $request->nota_corta;
            $cliente->save();

            DB::commit();
            return [
                'idclient' => $cliente->id
            ];
        } catch (Exception $e){
            DB::rollback();
        }
        
        
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            
            $cliente = Cliente::findOrFail($request->id);

            $persona = Persona::findOrFail($cliente->idpersona);


            $persona->nombre = $request->nombre;
            $persona->numero_documento = $request->numero_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();


            $cliente->nota_corta = $request->nota_corta;
            $cliente->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollback();
        }

    }

    public function selectCliente(Request $request){
        if(!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = Cliente::join('personas','clientes.idpersona','=','personas.id')
        ->where('personas.nombre','like','%'.$filtro.'%')
        ->orWhere('personas.numero_documento','like','%'.$filtro.'%')
        ->select('personas.id','clientes.id as idclient','personas.nombre','personas.numero_documento')
        ->orderBy('personas.nombre','asc')->get();

        return ['clientes' => $clientes];
    }
}
