<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;


class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        if($buscar == ''){
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            //->join('sucursales','ingresos.idsucursal','=','sucursales.'.$idsucursal)
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.numero_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total_compra',
            'ingresos.estado','personas.nombre','users.usuario')
            ->where('ingresos.idsucursal','=',$idsucursal)
            ->OrderBy('ingresos.id', 'desc')->paginate(3);
        }else{
            $ingresos = Ingreso::join('personas','ingresos.id','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.numero_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total_compra',
            'ingresos.estado','personas.nombre','users.usuario')
            ->where([['ingresos.'.$criterio, 'like', '%'. $buscar . '%'],['ingresos.idsucursal','=',$idsucursal]])->OrderBy('ingresos.id','desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'         => $ingresos->total(),
                'current_page'  => $ingresos->currentPage(),
                'per_page'      => $ingresos->perPage(),
                'last_page'     => $ingresos->lastPage(),
                'from'          => $ingresos->firstItem(),
                'to'            => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.numero_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total_compra',
        'ingresos.estado','personas.nombre','users.usuario')
        ->where('ingresos.id','=',$id)
        ->OrderBy('ingresos.id', 'desc')->take(1)->get();
       
        return ['ingreso' => $ingreso];
    }

    public function obtenerDetalle(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio_compra','articulos.nombre as articulo')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->OrderBy('detalle_ingresos.id', 'desc')->get();
       
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction(); 

            $mytime = Carbon::now('America/La_Paz');

            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->idsucursal = \Auth::user()->idsucursal;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->numero_comprobante = $request->numero_comprobante;
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total_compra = $request->total_compra;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

            $detalles = $request->data; //Array de Detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio_compra = $det['precio_compra'];
                $detalle->save();
            }

            DB::commit();
            return [
                'id' => $ingreso->id
            ];
        } catch (Exception $e){
            DB::rollback();
        }

        
    }

    public function pdf($id){
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.numero_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total_compra',
        'ingresos.estado','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email','users.usuario')
        ->where('ingresos.id','=',$id)
        ->OrderBy('ingresos.id', 'desc')->take(1)->get();

        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio_compra','articulos.nombre as articulo','articulos.numero_serie')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->OrderBy('detalle_ingresos.id', 'desc')->get();

        $numcomprabante = Ingreso::select('numero_comprobante')->where('id',$id)->get();
        $pdf = \PDF::loadView('pdf.ingreso',['ingreso' => $ingreso, 'detalles' => $detalles]);
        return $pdf->download('ingreso-'.$numcomprabante[0]->numero_comprobante.'.pdf');

    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }

    public function reporte(Request $request){
        if(!$request->ajax()) return redirect('/');
        //DB::raw('SUM(ventas.total) as total_ventas')
        $f1 = $f2 = date('Y-m-d');
        $f1 = $request->fechai;
        $f2 = $request->fechaf;
        $total_ingresos=0;
        $idsucursal = \Auth::user()->idsucursal;

        $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.numero_comprobante','ingresos.fecha_hora','ingresos.total_compra','personas.nombre','users.usuario')
        ->whereBetween('ingresos.fecha_hora',[$f1,$f2])
        ->OrderBy('ingresos.id', 'desc')
        ->paginate(100);

            foreach ($ingresos as $ingreso) {
                $total_ingresos = $total_ingresos + $ingreso->total_compra;
            }
            

            return [
                'pagination' => [
                    'total'         => $ingresos->total(),
                    'current_page'  => $ingresos->currentPage(),
                    'per_page'      => $ingresos->perPage(),
                    'last_page'     => $ingresos->lastPage(),
                    'from'          => $ingresos->firstItem(),
                    'to'            => $ingresos->lastItem(),
                ],
                'ingresos' => $ingresos, 'total_ingresos' => $total_ingresos
            ];
    }
}
