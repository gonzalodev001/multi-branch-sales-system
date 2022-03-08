<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Servicio_tecnico;

class ServicioTecnicoController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        //if(\Auth::user()->idrol == 1){}else{}
        if($buscar == ''){
            $servicios = Servicio_tecnico::join('clientes','servicio_tecnicos.idcliente','=','clientes.id')
            ->join('personas','clientes.idpersona','=','personas.id')
            ->join('users','servicio_tecnicos.idusuario','=','users.id')
            ->select('servicio_tecnicos.id','servicio_tecnicos.descipcion_equipo','servicio_tecnicos.defectos_entrada','servicio_tecnicos.defectos_salida',
            'servicio_tecnicos.fecha_hora','servicio_tecnicos.fecha_hora_salida','servicio_tecnicos.estado','personas.nombre','users.usuario')
            ->where('servicio_tecnicos.idsucursal','=',$idsucursal)
            ->OrderBy('servicio_tecnicos.id', 'desc')->paginate(3);
        }else{
            $servicios = Servicio_tecnico::join('clientes','servicio_tecnicos.idcliente','=','clientes.id')
            ->join('personas','clientes.idpersona','=','personas.id')
            ->join('users','servicio_tecnicos.idusuario','=','users.id')
            ->select('servicio_tecnicos.id','servicio_tecnicos.descipcion_equipo','servicio_tecnicos.defectos_entrada','servicio_tecnicos.defectos_salida',
            'servicio_tecnicos.fecha_hora','servicio_tecnicos.fecha_hora_salida','servicio_tecnicos.estado','personas.nombre','users.usuario')
            ->where([['servicio_tecnicos.'.$criterio, 'like', '%'. $buscar . '%'],['servicio_tecnicos.idsucursal','=',$idsucursal]])
            ->OrderBy('servicio_tecnicos.id','desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'         => $servicios->total(),
                'current_page'  => $servicios->currentPage(),
                'per_page'      => $servicios->perPage(),
                'last_page'     => $servicios->lastPage(),
                'from'          => $servicios->firstItem(),
                'to'            => $servicios->lastItem(),
            ],
            'servicios' => $servicios
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction(); 

            $mytime = Carbon::now('America/La_Paz');
            $servicio = new Servicio_tecnico();
            $servicio->idcliente = $request->idcliente;
            $servicio->idusuario = \Auth::user()->id;
            $servicio->idsucursal = \Auth::user()->idsucursal;
            $servicio->descipcion_equipo = $request->descipcion_equipo;
            $servicio->defectos_entrada = $request->defectos_entrada;
            $servicio->defectos_salida = $request->defectos_salida;
            $servicio->fecha_hora = $mytime->toDateTimeString();
            $servicio->fecha_hora_salida = $request->fecha_hora_salida;
            $servicio->estado = 'Reparacion';
            $servicio->save();

            DB::commit();
            return [
                'id' => $servicio->id
            ];
        } catch (Exception $e){
            DB::rollback();
        }

        
    }

    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $mytime = Carbon::now('America/La_Paz');
        $servicio = Servicio_Tecnico::findOrFail($request->id);
        $servicio->defectos_salida = $request->defectos_salida;
        $servicio->fecha_hora_salida = $mytime->toDateTimeString();
        $servicio->estado = 'Repadaro';
        $servicio->save();

    }

    public function pdf($id){
        
        $servicio = Servicio_tecnico::join('clientes','servicio_tecnicos.idcliente','=','clientes.id')
        ->join('personas','clientes.idpersona','=','personas.id')
        ->join('users','servicio_tecnicos.idusuario','=','users.id')
        ->select('servicio_tecnicos.id','servicio_tecnicos.descipcion_equipo','servicio_tecnicos.defectos_entrada','servicio_tecnicos.defectos_salida',
        'servicio_tecnicos.fecha_hora','servicio_tecnicos.fecha_hora_salida','servicio_tecnicos.estado','personas.nombre','users.usuario')
        ->where('servicio_tecnicos.id','=',$id)
        ->OrderBy('servicio_tecnicos.id', 'desc')->take(1)->get();

        
        $pdf = \PDF::loadView('pdf.servicio',['servicio' => $servicio]);
        return $pdf->download('servicio-técnico'.$id.'.pdf');
    }

    public function listarPdf(){
        $idsucursal = \Auth::user()->idsucursal;

        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
        ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
        ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo',
        'categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
        ->where('existencia_sucursales.idsucursal','=', $idsucursal)
        ->OrderBy('articulos.nombre', 'desc')->get();

        $cont = Articulo::count();

        $pdf = \PDF::loadView('pdf.articulospdf',['articulos'=>$articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }

    
}
