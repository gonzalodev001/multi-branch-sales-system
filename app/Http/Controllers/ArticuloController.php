<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Articulo;
use App\Existencia_sucursale;

class ArticuloController extends Controller
{
    
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;
        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where('existencia_sucursales.idsucursal','=', $idsucursal)
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where([['articulos.'.$criterio, 'like', '%'. $buscar . '%'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'         => $articulos->total(),
                'current_page'  => $articulos->currentPage(),
                'per_page'      => $articulos->perPage(),
                'last_page'     => $articulos->lastPage(),
                'from'          => $articulos->firstItem(),
                'to'            => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function listarArticulo(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;
        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where('existencia_sucursales.idsucursal','=', $idsucursal)
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where([['articulos.'.$criterio, 'like', '%'. $buscar . '%'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return ['articulos' => $articulos];
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

    public function listarArticuloVenta(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion','sucursales.nombre as nombre_sucursal')
            ->where([['existencia_sucursales.stock','>','0'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion','sucursales.nombre as nombre_sucursal')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')->OrderBy('id','desc')
            ->where([['existencia_sucursales.stock','>','0'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return ['articulos' => $articulos];
    }

    public function listarArticuloSucursal(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion','sucursales.nombre as nombre_sucursal')
            ->where([['existencia_sucursales.stock','>','0'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion','sucursales.nombre as nombre_sucursal')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')->OrderBy('id','desc')
            ->where([['existencia_sucursales.stock','>','0'],['existencia_sucursales.idsucursal','!=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return ['articulos' => $articulos];
    }

    public function buscarArticulo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idsucursal = \Auth::user()->idsucursal;
        $filtro = $request->filtro;
        //$articulos = Articulo::where([['numero_serie','=', $filtro],['existencia_sucursales.idsucursal','=', $idsucursal]])
        $articulos = Articulo::where('numero_serie','=', $filtro)
        ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function buscarArticuloVenta(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idsucursal = \Auth::user()->idsucursal;
        $filtro = $request->filtro;
        $articulos = Articulo::join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
        ->where('numero_serie','=', $filtro)
        ->select('articulos.id','articulos.nombre','existencia_sucursales.stock','precio_venta')
        ->where([['existencia_sucursales.stock','>','0'],['existencia_sucursales.idsucursal','=', $idsucursal]])
        ->orderBy('articulos.nombre','asc')->take(1)->get();

        return ['articulos' => $articulos];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $articulo = new Articulo();
            $articulo->idcategoria = $request->idcategoria;
            $articulo->nombre = $request->nombre;
            $articulo->marca = $request->marca;
            $articulo->numero_serie = $request->numero_serie;
            $articulo->modelo = $request->modelo;
            $articulo->precio_venta = $request->precio_venta;
            $articulo->descripcion = $request->descripcion;
            $articulo->condicion = '1';
            $articulo->save();

            $existencia = new Existencia_sucursale;
            $existencia->idsucursal = 1;
            $existencia->idarticulo = $articulo->id;
            $existencia->stock = 0;
            $existencia->save();

            $existencia = new Existencia_sucursale;
            $existencia->idsucursal = 2;
            $existencia->idarticulo = $articulo->id;
            $existencia->stock = 0;
            $existencia->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollback();
        }

    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->nombre = $request->nombre;
        $articulo->marca = $request->marca;
        $articulo->numero_serie = $request->numero_serie;
        $articulo->modelo = $request->modelo;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();

    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

    public function listarArticuloxCategoria(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;
        $vec = [];
        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where('existencia_sucursales.idsucursal','=', $idsucursal)
            ->OrderBy('articulos.id', 'desc')->paginate(10);
            $datos = ['marca' => 'honda','color' => 'negro'];
            $datos = array_except($datos, ['color']);   
            
            //$articulos = array_except($articulos, )
            foreach($articulos as $a){
                $vec[] = $a->nombre;//$this->nombre();
                //$articulos[]=$vec;
            }
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo','categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion')
            ->where([['articulos.'.$criterio, 'like', '%'. $buscar . '%'],['existencia_sucursales.idsucursal','=', $idsucursal]])
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return [
            'pagination' => [
                'total'         => $articulos->total(),
                'current_page'  => $articulos->currentPage(),
                'per_page'      => $articulos->perPage(),
                'last_page'     => $articulos->lastPage(),
                'from'          => $articulos->firstItem(),
                'to'            => $articulos->lastItem(),
            ],
            'vec' => $vec
        ];
    }
    public function nombre(){
        return "veymar";
    }

    public function listarArticuloAdmin(Request $request){
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idsucursal = \Auth::user()->idsucursal;

        if($buscar == ''){
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion',
            'sucursales.nombre as nombre_sucursal')
            ->where('existencia_sucursales.stock','>','0')
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            ->join('existencia_sucursales','articulos.id','=','existencia_sucursales.idarticulo')
            ->join('sucursales','existencia_sucursales.idsucursal','=','sucursales.id')
            ->select('articulos.id','articulos.idcategoria','articulos.nombre','articulos.marca','articulos.numero_serie','articulos.modelo',
            'categorias.nombre as nombre_categoria','articulos.precio_venta','existencia_sucursales.stock','articulos.descripcion','articulos.condicion',
            'sucursales.nombre as nombre_sucursal')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')->OrderBy('id','desc')
            ->where('existencia_sucursales.stock','>','0')
            ->OrderBy('articulos.id', 'desc')->paginate(10);
        }
        
        return ['articulos' => $articulos];
    }
}
 
