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
                        <i class="fa fa-align-justify"></i> Servicio Técnico
                        
                    </div>
                    <!--Listado-->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio" >
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="num_comprobante">Descripcion</option>
                                            <option value="fecha_hora">Fecha-Hora</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarServicio(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" @click="listarServicio(1,buscar,criterio)" class="btn btn-success active"><i class="fa fa-search"></i> Buscar</button>
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
                                            <th>Servicio</th>
                                            <th>Fecha Entrada</th>
                                            <th>Fecha Salida</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="servicio in arrayServicio" :key="servicio.id">
                                            
                                            <td v-text="servicio.usuario"></td>
                                            <td v-text="servicio.nombre"></td>
                                            <td >Servicio Técnico</td>
                                            <td v-text="servicio.fecha_hora"></td>
                                            <td v-text="servicio.fecha_hora_salida"></td>
                                            <td v-text="servicio.estado"></td>
                                            <td>
                                                <button type="button" @click="mostrarServicio(servicio)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                                </button> &nbsp;
                                                <button type="button" @click="pdfServicio(servicio.id)" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                                </button> &nbsp;
                                                <template v-if="servicio.estado =='Registrado'">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarVenta(servicio.id)">
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
                                    <div v-show="errorServicio" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjServicio" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Descripción de Equipo <span style="color:red;" v-show="descipcion_equipo==''">(*Ingreso)</span></label>
                                        
                                        <textarea class="form-control" rows="7" v-model="descipcion_equipo"></textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Descripción a Reparar <span style="color:red;" v-show="defectos_entrada==''">(*Ingreso)</span></label>
                                        
                                        <textarea class="form-control" rows="7" v-model="defectos_entrada"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Solución y Fallas <span style="color:red;" v-show="defectos_salida==''">(*Ingreso)</span></label>
                                        
                                        <textarea class="form-control" rows="7" v-model="defectos_salida"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarServicio()">Registrar Servicio</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarServicio()">Actualizar</button>
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
                                
                                <div class="col-md-4">
                                    <label>Fecha Entrada</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                                <div class="col-md-4">
                                    <label>Fecha Salida</label>
                                    <p v-text="fecha_hora_salida"></p>
                                </div>
                                <div class="col-md-4">
                                    <label>Fecha</label>
                                    <p v-text="estado"></p>
                                </div>
                                
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <label for="">Descripción del Equipo</label>
                                    <p v-text="descipcion_equipo"></p>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <label for="">Descripción a Reparar</label>
                                    <p v-text="defectos_entrada"></p>
                                </div>
                            </div>
                            <div class="form-group row border">
                                <div class="col-md-7">
                                    <label for="">Solución y Fallas</label>
                                    <p v-text="defectos_salida"></p>
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
                servicio_id : 0,
                idcliente : 0,
                nombre_cliente: '',
                numero_documento : 0,
                nombre : '',
                cliente: '',
                descipcion_equipo : '',
                defectos_entrada : '',
                defectos_salida : '',
                fecha_hora : '',
                fecha_hora_salida : '',
                estado : '',
                arrayServicio : [],
                arrayCliente : [],
                listado : 1,
                modal : 0,
                modalpersona : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorServicio : 0,
                errorMostrarMsjServicio : [],
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
            listarServicio (page,buscar,criterio){
                let me = this;
                var url = '/servicio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayServicio = respuesta.servicios.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
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
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualizar la pagina actual
                me.pagination.current_page = page;
                //Enviar la peticion para visualizar la data de esta pagina
                me.listarServicio(page,buscar,criterio);
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
            },
            registrarServicio (){
                if(this.validarServicio()){
                    return;
                }
                let me = this;
                axios.post('/servicio/registrar', {
                    'idcliente' : this.idcliente,
                    'descipcion_equipo' : this.descipcion_equipo,
                    'defectos_entrada' : this.defectos_entrada,
                    'defectos_salida' : this.defectos_salida
                }).then(function (response) {
                    me.listado=1;
                    me.listarServicio(1,'','fecha_hora');
                    me.idcliente=0;
                    me.descipcion_equipo='';
                    me.defectos_entrada='';
                    me.defectos_salida='';
                    window.open('http://localhost:8000/servicio/pdf/'+ response.data.id + ',' + '_blank');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarServicio(){
                //if(this.validarServicio()){
                    //return;
                //}
                let me = this;
                axios.put('/servicio/actualizar', {
                    'defectos_salida' : this.defectos_salida,
                    'id' : this.servicio_id
                }).then(function (response) {
                    
                    me.listado=1;
                    me.listarServicio(1,'','fecha_hora');
                    me.idcliente=0;
                    me.descipcion_equipo='';
                    me.defectos_entrada='';
                    me.defectos_salida='';
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
            validarServicio(){
                let me = this;
                me.errorServicio=0;
                me.errorMostrarMsjServicio = [];

                if(me.idcliente==0) me.errorMostrarMsjServicio.push("Seleccione un cliente.");
                if(me.descipcion_equipo==0) me.errorMostrarMsjServicio.push("Describa el equipo electrónico.");
                if(me.defectos_entrada==0) me.errorMostrarMsjServicio.push("Ingrese los defectosdel equipo.");
                
                if(me.errorMostrarMsjServicio.length) me.errorServicio= 1;

                return me.errorServicio;
            },
            mostrarDetalle(){
                let me  = this;
                this.listado = 0;
                this.tipoAccion=1;
                me.idcliente=0;
                me.descipcion_equipo='';
                me.defectos_entrada='';
                me.defectos_salida='';
                me.total_compra=0.0;
                
            },
            limpiarcampos(){
                me.idcliente=0;
                me.descipcion_equipo='';
                me.defectos_entrada='';
                me.defectos_salida='';
                this.listado=1;
            },
            ocultarDetalle(){
                this.listado = 1;
            },
            mostrarServicio(data =[]){
                let me  = this;
                this.listado = 0;
                this.tipoAccion=2;
                this.servicio_id= data['id'];
                this.descipcion_equipo = data['descipcion_equipo'];
                this.defectos_entrada = data['defectos_entrada'];
                this.defectos_salida = data['defectos_salida'];
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
                //obtener los datos de los detalles
                

            },
            pdfServicio(id){
                window.open('http://localhost:8000/servicio/pdf/'+ id + ',' + '_blank');
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
            this.listarServicio(1,this.buscar,this.criterio);
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
