<template>
    <main class="main">
            <!-- Breadcrumb -->
            <!--<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>-->
            <div class="form-group row"></div>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header card-headerr">
                        <i class="fa fa-align-justify"></i> Ventas
                        
                    </div>
                    <!--Listado-->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio" >
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="num_comprobante">Número Comprobante</option>
                                            <option value="fecha_hora">Fecha-Hora</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarVenta(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" @click="listarVenta(1,buscar,criterio)" class="btn btn-success active"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            
                                <div class="col-md-1">
                                    <button type="button" @click="mostrarDetalle()" class="btn btn-danger active" >
                                        <i class="icon-plus"></i>&nbsp;Nuevo
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            
                                            <th>Usuario</th>
                                            <th>Cliente</th>
                                            <th>Número Comprobante</th>
                                            <th>Fecha Hora</th>
                                            <th>Total</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="venta in arrayVenta" :key="venta.id">
                                            
                                            <td v-text="venta.usuario"></td>
                                            <td v-text="venta.nombre"></td>
                                            <td v-text="venta.num_comprobante"></td>
                                            <td v-text="venta.fecha_hora"></td>
                                            <td v-text="venta.total"></td>
                                            <td v-text="venta.impuesto"></td>
                                            <td v-text="venta.estado"></td>
                                            <td>
                                                <button type="button" @click="VerVenta(venta.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                                </button> &nbsp;
                                                <button type="button" @click="pdfVenta(venta.id)" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                                </button> &nbsp;
                                                <template v-if="venta.estado =='Registrado'">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarVenta(venta.id)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>
                    <!--Fin Listado-->
                    <!--Detalle Ingreso-->
                    <template v-else-if="listado==0">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select
                                            @search="selectCliente"
                                            label="nombre"
                                            :options="arrayCliente"
                                            placeholder="Buscar Cliente..."
                                            @input="getDatosCliente"
                                        />
                                        
                                    </div>
                                    
                                </div>
                                 <div class="col-md-3">
                                    <label for=""> (*) </label>
                                    <button @click="registrarCliente()" class="btn btn-primary form-control">Nuevo</button>
                                </div>
                               <!--<div class="col-md-4">
                                    <label>Tipo Comprobante(*)</label>
                                    <select class="form-control" v-model="tipo_comprobante">
                                        <option value="0" disabled>Seleccione</option>
                                        <option value="Comprobante">Comprobante</option>
                                        <option value="Recibo">Recibo</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número Comprobante(*)</label>
                                        <input type="text" class="form-control" v-model="num_comprobante" placeholder="000x"/>
                                    </div>
                                </div>-->
                                <div class="col-md-12">
                                    <div v-show="errorVenta" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjVEnta" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Artículo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span> </label>
                                        <div class="form-inline">
                                            <input type="text" class="form-control" v-model="numero_serie" @keyup.enter="buscarArticulo()" placeholder="Ingrese artículo"/>
                                            <button @click="abrirModal()" class="btn btn-primary">...</button>
                                            <input type="text" readonly class="form-control" v-model="articulo">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Artículo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Descuento</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                                <td v-text="detalle.articulo">
                                                    
                                                </td>
                                                <td>
                                                    <input v-model="detalle.precio" type="number" min="1.0"  value="0" step="0.1" class="form-control">
                                                </td>
                                                <td>
                                                    <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span>
                                                    <input v-model="detalle.cantidad" type="number" value="1" min="0" class="form-control ">
                                                </td>
                                                <td>
                                                    <span style="color:red;" v-show="detalle.descuento>(detalle.precio*detalle.cantidad)">Descuento superior</span>
                                                    <input v-model="detalle.descuento" type="number" min="1.0" value="0" step="0.1" class="form-control ">
                                                </td>
                                                <td>
                                                    {{ detalle.precio*detalle.cantidad-detalle.descuento }}
                                                </td>
                                            </tr>
                                            <!--<tr style="background-color: #c9f7c7">
                                                <td colspan="5" align="right"><strong>Total Parcial:</strong></td>
                                                <td>$ {{ totalParcial=(total-totalImpuesto).toFixed(2) }}</td>
                                            </tr>
                                            <tr style="background-color: #c9f7c7">
                                                <td colspan="5" align="right"><strong>Total Impuesto:</strong></td>
                                                <td>$ {{ totalImpuesto=(total*impuesto).toFixed(2) }} </td>
                                            </tr>-->
                                            <tr style="background-color: #c9f7c7">
                                                <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                                <td>$ {{ total=calcularTotal }} </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="6">
                                                    No hay artículos agregados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                    <button type="button" class="btn btn-primary" @click="registrarVenta()">Registrar Venta</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--Fin Detalle Ingreso-->
                    <!-- Ver Ingreso-->
                    <template v-else-if="listado==2">
                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <p v-text="cliente"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Impuesto</label>
                                    <p v-text="impuesto"></p>
                                </div>
                                <div class="col-md-4">
                                    <label>Fecha</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Número Comprobante</label>
                                        <p v-text="num_comprobante"></p>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Artículo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Descuento</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                <td v-text="detalle.articulo">
                                                    
                                                </td>
                                                <td v-text="detalle.precio">
                                                    
                                                </td>
                                                <td v-text="detalle.cantidad">
                                                    
                                                </td>
                                                <td v-text="detalle.descuento">
                                                    
                                                </td>
                                                <td>
                                                    {{ detalle.precio*detalle.cantidad-detalle.descuento }}
                                                </td>
                                            </tr>
                                            <!--<tr style="background-color: #c9f7c7">
                                                <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                                <td>$ {{ totalParcial=(total-totalImpuesto).toFixed(2) }}</td>
                                            </tr>-->
                                            <!--<tr style="background-color: #c9f7c7">
                                                <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                                <td>$ {{ totalImpuesto=(total*impuesto).toFixed(2) }} </td>
                                            </tr>-->
                                            <tr style="background-color: #c9f7c7">
                                                <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                                <td>$ {{ total }} </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">
                                                    No hay artículos agregados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--Fin ver Ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header card-headerr">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA" >
                                            <option value="nombre">Nombre</option>
                                            <option value="descripcion">Descripción</option>
                                            <option value="numero_serie">Numero de Serie</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                        <div class="col-md-1">
                                            <button type="submit" @click="listarArticuloSucursal(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar en Sucursal</button>      
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Marca</th>
                                            <th>N/S</th>
                                            <th>Modelo</th>
                                            <th>Sucursal</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button> 
                                            </td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.marca"></td>
                                            <td v-text="articulo.numero_serie"></td>
                                            <td v-text="articulo.modelo"></td>
                                            <td v-text="articulo.nombre_sucursal"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td v-text="articulo.stock"></td>
                                            <td>
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!--<div class="col-md-12">
                                    <div v-show="errorArt" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <label for="" v-text="errorMostrarMsjArt"></label>
                                            <div v-for="error in errorMostrarMsjVEnta" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->

            
            
            
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import Swal from 'sweetalert2';
    export default {
        data(){
            return {
                venta_id : 0,
                idcliente : 0,
                nombre_cliente: '',
                numero_documento : 0,
                nombre : '',
                cliente: '',
                tipo_comprobante : 'Comprobante',
                num_comprobante : '',
                impuesto : 0.13,
                total : 0.0,
                totalImpuesto : 0.0,
                totalParcial : 0.0,
                estado : '',
                arrayVenta : [],
                arrayDetalle : [],
                arrayCliente : [],
                listado : 1,
                modal : 0,
                modalpersona : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVEnta : [],
                errorArt : 0,
                errorMostrarMsjArt : '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio :'num_comprobante',
                buscar : '',
                criterioA : 'nombre',
                buscarA : '',
                arrayArticulo : [],
                idarticulo : 0,
                numero_serie : '',
                articulo : '',
                precio : 0,
                cantidad : 0,
                descuento : 0,
                stock : 0,
                fecha_hora: '',
                sucursal: ''

            }

        },
        components : {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elementos de la paginación
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var resultado = 0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + (this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento);
                }
                return resultado;
            }
        },
        methods : {
            listarVenta (page,buscar,criterio){
                let me = this;
                var url = '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            selectCliente(search,loading){
                let me = this;
                loading(true)

                var url = '/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q:search
                    me.arrayCliente = respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getDatosCliente(vall){
                let me = this;
                me.loading = true;
                me.idcliente = vall.idclient;
            },
            buscarArticulo(){
                let me = this;
                var url = '/articulo/buscarArticuloVenta?filtro=' + me.numero_serie;

                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos;
                    
                    if(me.arrayArticulo.length>0){
                        me.articulo = me.arrayArticulo[0]['nombre'];
                        me.idarticulo = me.arrayArticulo[0]['id'];
                        me.precio = me.arrayArticulo[0]['precio_venta'];
                        me.stock = me.arrayArticulo[0]['stock'];
                    }else{
                        me.articulo = 'No existe artículo';
                        me.idarticulo = 0;
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualizar la pagina actual
                me.pagination.current_page = page;
                //Enviar la peticion para visualizar la data de esta pagina
                me.listarVenta(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0; i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo==id){
                        sw=true;
                    }
                }
                return sw;
            },
            agregarDetalle(){
                let me = this;
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0){

                }else{
                    if(me.encuentra(me.idarticulo)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!'
                        });
                    }else{
                        if(me.cantidad > me.stock) {
                            swal({
                                type: 'error',
                                title: 'Error...',
                                text: 'No hay stock disponible!'
                            });
                        }else{
                            me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                descuento: me.descuento,
                                stock: me.stock
                            });
                            me.numero_serie="";
                            me.idarticulo=0;
                            me.articulo="";
                            me.cantidad=0;
                            me.precio=0;
                            me.descuento=0;
                            me.stock=0;
                        }
                    }
                     
                }

            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index,1);
            },
            agregarDetalleModal(data =[]){
                let me = this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!'
                        });
                    }else{
                        me.arrayDetalle.push({
                            idarticulo: data['id'],
                            articulo: data['nombre'],
                            cantidad: 1,
                            precio: data['precio_venta'],
                            descuento : 0,
                            stock: data['stock']
                        });
                    }
            },
            listarArticulo (buscar,criterio){
                let me = this;
                var url = '/articulo/listarArticuloVenta?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            listarArticuloSucursal (buscar,criterio){
                let me = this;
                var url = '/articulo/listarArticuloSucursal?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
            },
            registrarVenta (){
                if(this.validarVenta()){
                    return;
                }
                let me = this;
                axios.post('/venta/registrar', {
                    'idcliente' : this.idcliente,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'data' : this.arrayDetalle
                }).then(function (response) {
                    me.listado=1;
                    me.listarVenta(1,'','num_comprobante');
                    me.idcliente=0;
                    me.tipo_comprobante='Comprobante';
                    me.num_comprobante='';
                    me.numero_serie='';
                    me.impuesto=0.13;
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.stock=0;
                    me.descuento=0;
                    me.arrayDetalle=[];
                    window.open('http://localhost:8000/venta/pdf/'+ response.data.id + ',' + '_blank');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarPersona(){
                if(this.validarPersona()){
                    return;
                }
                let me = this;
                axios.put('/user/actualizar', {
                    'nombre' : this.nombre,
                    'numero_documento' : this.numero_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idrol' : this.idrol,
                    'id' : this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            validarVenta(){
                let me = this;
                me.errorVenta=0;
                me.errorMostrarMsjVEnta = [];
                var art;

                me.arrayDetalle.map(function(x){
                    if(x.cantidad>x.stock){
                        art=x.articulo + " con stock insuficiente";
                        me.errorMostrarMsjVEnta.push(art);
                    }
                });

                if(me.idcliente==0) me.errorMostrarMsjVEnta.push("Seleccione un cliente.");
                if(me.tipo_comprobante==0) me.errorMostrarMsjVEnta.push("Seleccione el comprobante.");
                if(me.numero_comprobante==0) me.errorMostrarMsjVEnta.push("Ingrese el número de comprobante.");
                if(me.impuesto==0) me.errorMostrarMsjVEnta.push("Ingrese el impuesto de venta.");
                if(me.arrayDetalle<=0) me.errorMostrarMsjVEnta.push("Ingrese Detalle.");
                if(me.precio_venta<=0) me.errorMostrarMsjVEnta.push("El precio no debe ser menor a cero.");
                if(me.cantidad<0) me.errorMostrarMsjVEnta.push("La cantidad no debe ser menor a cero.");
                if(me.descuento<0) me.errorMostrarMsjVEnta.push("El descuento no debe ser menor a cero.");
                if(me.precio<0) me.errorMostrarMsjVEnta.push("El precio no debe ser menor a cero.");
                for(var i=0; i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].precio<0){
                        this.errorMostrarMsjVEnta.push("Ingrese un precio válido no menor a cero.");
                    }
                    if(this.arrayDetalle[i].cantidad<0){
                        this.errorMostrarMsjVEnta.push("Ingrese una cantidad válida no menor a cero.");
                    }
                }
                if(me.errorMostrarMsjVEnta.length) me.errorVenta= 1;

                return me.errorVenta;
            },
            mostrarDetalle(){
                let me  = this;
                this.listado = 0;
                me.idproveedor=0;
                me.tipo_comprobante='Factura';
                me.numero_serie='';
                me.impuesto=0.13;
                me.total_compra=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio_compra=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado = 1;
            },
            VerVenta(id){
                let me = this;
                me.listado=2;
        

                //Obtener los datos del ingreso
                var arrayVentaT=[];
                var url = '/venta/obtenerCabecera?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    arrayVentaT = respuesta.venta;
                    
                    me.cliente = arrayVentaT[0]['nombre'];
                    me.fecha_hora = arrayVentaT[0]['fecha_hora'];
                    me.num_comprobante = arrayVentaT[0]['num_comprobante'];
                    me.impuesto = arrayVentaT[0]['impuesto'];
                    me.total = arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });
                //obtener los datos de los detalles
                var urld = '/venta/obtenerDetalle?id=' + id;
                axios.get(urld).then(function (response) {
                    var respuesta = response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });

            },
            pdfVenta(id){
                window.open('http://localhost:8000/venta/pdf/'+ id + ',' + '_blank');
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
            },
            abrirModal(){
                this.arrayArticulo = [];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                                
                          
            },
            desactivarVenta(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de anular este ingreso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/ingreso/desactivar',{
                        'id' : id
                    }).then(function (response){
                        me.listarIngreso(1,'','numero_comprobante');
                        swalWithBootstrapButtons(
                        'Anulado!',
                        'El ingreso ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            activarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar este usuario?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/user/activar',{
                        'id' : id
                    }).then(function (response){
                        me.listarPersona(1,'','nombre');
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El usuario ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            registrarCliente (){
                let me = this;
                
                /*swal.fire({
                    title : 'REGISTRAR CLIENTE',
                    showCancelButton:true,
                    html:
                        
                        `<div class="form-control">`+
                        `Nombre: <input id="input1" type="text" class="swal2-input">` +

                         `Ci: <input id="input2" type="text" class="swal2-input">`+
                         `</div>`,

                    preConfirm:function(){
                                    me.nombre_cliente = $('#input1').val();
                                    me.numero_documento = $('#input2').val();
                                     // use user input value freely 
                                     
                    }
                    
                })
                if(!me.nombre_cliente==''){
                    axios.post('/cliente/registrar', {
                         'nombre' : this.nombre_cliente,
                         'numero_documento' : this.numero_documento
                    }).then(function (response) {
                        me.nombre_cliente = '';
                        me.numero_documento = 0;

                    }).catch(function (error) {
                                                // handle error
                        console.log(error);
                    });
                }*/
                const { value: formValues } =  Swal.fire({
                    title: 'REGISTRAR CLIENTE',
                    html:
                        `<div class="form-control">`+
                        `Nombre: <input id="input1" type="text" class="swal2-input">` +

                         `Ci: <input id="input2" type="text" class="swal2-input">`+
                         `</div>`,
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            me.nombre_cliente = $('#input1').val(),
                            me.numero_documento = $('#input2').val(),
                            axios.post('/cliente/registrar', {
                                'nombre' : this.nombre_cliente,
                                'numero_documento' : this.numero_documento
                            }).then(function (response) {
                                me.nombre_cliente = '';
                                me.numero_documento = 0;
                                me.idcliente = response.data.idclient

                            }).catch(function (error) {
                                                        // handle error
                                console.log(error);
                            })
                        ]
                    }
                    })

                    
                
            },validaCliente(){

            }
        },
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position : absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px){
        .btnagregar {
            margin-top: 2rem;
        }
    }
    .card-headerr{
        background-color: #013252;
        color:white;
        font-weight: 800;
    }
    
</style>
