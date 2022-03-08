<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar; 
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        //if(\Auth::user()->idrol == 1){}else{}
        if($buscar == ''){
            $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
            ->join('personas','clientes.idpersona','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->where('ventas.idsucursal','=',$idsucursal)
            ->OrderBy('ventas.id', 'desc')->paginate(3);
        }else{
            $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
            ->join('personas','clientes.idpersona','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->where([['ventas.'.$criterio, 'like', '%'. $buscar . '%'],['ventas.idsucursal','=',$idsucursal]])->OrderBy('ventas.id','desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'         => $ventas->total(),
                'current_page'  => $ventas->currentPage(),
                'per_page'      => $ventas->perPage(),
                'last_page'     => $ventas->lastPage(),
                'from'          => $ventas->firstItem(),
                'to'            => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;
        $venta = Venta::join('clientes','ventas.idcliente','=','clientes.id')
        ->join('personas','clientes.idpersona','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
        'ventas.estado','personas.nombre','personas.numero_documento','users.usuario')
        ->where('ventas.id','=',$id)
        ->OrderBy('ventas.id', 'desc')->take(1)->get();
       
        return ['venta' => $venta];
    }

    public function obtenerDetalle(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento','articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->OrderBy('detalle_ventas.id', 'desc')->get();
       
        return ['detalles' => $detalles];
    }

    public function pdf($id){
        
        $venta = Venta::join('clientes','ventas.idcliente','=','clientes.id')
        ->join('personas','clientes.idpersona','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.num_comprobante','ventas.created_at','ventas.impuesto','ventas.total',
        'ventas.estado','personas.nombre','personas.numero_documento','personas.direccion','personas.telefono','personas.email',
        'users.usuario')
        ->where('ventas.id','=',$id)
        ->OrderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento','articulos.nombre as articulo')
        ->where('detalle_ventas.idventa','=',$id)
        ->OrderBy('detalle_ventas.id', 'desc')->get();

        $numventa = Venta::select('num_comprobante')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.venta',['venta' => $venta, 'detalles' => $detalles]); 
        return $pdf->download('venta-'.$numventa[0]->num_comprobante.'.pdf');
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction(); 

            $mytime = Carbon::now('America/La_Paz');
            $num_comprobante = $this->ultimo();
            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->idsucursal = \Auth::user()->idsucursal;
            $venta->num_comprobante = $num_comprobante;
            $venta->codigo_control = 'AAA';
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data; //Array de Detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->save();
            }

            DB::commit();
            return [
                'id' => $venta->id
            ];
        } catch (Exception $e){
            DB::rollback();
        }

        
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }

    public function ultimo(){
        $venta = DB::table('ventas')->get()->last();

        $num = (int)$venta->num_comprobante;

        $num = $num + 1; 
        //convierte cadena a array
        $array = str_split($num, 1);
        
        $numero = count($array);
        //añade al principio el 0 del array
        for ($i = $numero; $i < 6; $i++){
            array_unshift($array, "0");
        }
        //convierte el array en cadena
        $numero_comprobante = implode($array);
        return $numero_comprobante;
    }

    public function reporte(Request $request){
        if(!$request->ajax()) return redirect('/');
        //DB::raw('SUM(ventas.total) as total_ventas')
        $f1 = $f2 = date('Y-m-d');
        $f1 = $request->fechai;
        $f2 = $request->fechaf;
        $total_ventas=0;
        $idsucursal = \Auth::user()->idsucursal;

        $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
            ->join('personas','clientes.idpersona','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.estado','personas.nombre','users.usuario')
            ->whereBetween('ventas.fecha_hora',[$f1,$f2])
            ->OrderBy('ventas.id', 'desc')
            ->paginate(100);

            foreach ($ventas as $venta) {
                $total_ventas = $total_ventas + $venta->total;
            }
            

            return [
                'pagination' => [
                    'total'         => $ventas->total(),
                    'current_page'  => $ventas->currentPage(),
                    'per_page'      => $ventas->perPage(),
                    'last_page'     => $ventas->lastPage(),
                    'from'          => $ventas->firstItem(),
                    'to'            => $ventas->lastItem(),
                ],
                'ventas' => $ventas, 'total_ventas' => $total_ventas
            ];
    }
}
