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
                        <i class="fa fa-align-justify"></i> USUARIOS
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio" >
                                      <option value="nombre">Nombre</option>
                                      <option value="numero_documento">Número Documento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-success active"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                            
                            <div class="col-md-1">
                                <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-danger active" >
                                    <i class="icon-plus"></i>&nbsp;Nuevo
                                </button>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Nro. Documento</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Sucursal</th>
                                    <th>Opciones</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.numero_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.usuario"></td>
                                    <td v-text="persona.rol"></td>
                                    <td v-text="persona.sucursal"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-info btn-sm">
                                          <i class="fa fa-edit"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(persona.id)">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(persona.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Nombre</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de cliente">
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">CI/NIT</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="numero_documento" class="form-control" placeholder="Numero de documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Direccion</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese dirección.">
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">telefono</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Ingrese telefono.">
                                    </div> 
                                </div>
                                <div class="form-group row">
                                    
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">email</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="email" class="form-control" placeholder="Ingrese email.">
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Usuario (*)</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Ingrese nombre de usuario.">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Password (*)</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password de acceso.">
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Rol (*)</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" v-model="idrol"> 
                                            <option value="0">Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>

                                    
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-1">
                                        <label class="form-control-label text-right" for="text-input">Sucursal (*)</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" v-model="idsucursal"> 
                                            <option value="0">Seleccione una sucursal</option>
                                            <option v-for="sucursal in arraySucursal" :key="sucursal.id" :value="sucursal.id" v-text="sucursal.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    export default {
        data(){
            return {
                persona_id : 0,
                nombre : '',
                numero_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario : '',
                password : '',
                rol : '',
                sucursal : '',
                idrol : 0,
                idsucursal : 0,
                arrayPersona : [],
                arrayRol : [],
                arraySucursal : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio :'nombre',
                buscar : ''
            }

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
            }
        },
        methods : {
            listarPersona (page,buscar,criterio){
                let me = this;
                var url = '/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectRol(){
                let me = this;
                var url = '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            selectSucursal(){
                let me = this;
                var url = '/sucursal/selectSucursal';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arraySucursal = respuesta.sucursales;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualizar la pagina actual
                me.pagination.current_page = page;
                //Enviar la peticion para visualizar la data de esta pagina
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona (){
                if(this.validarPersona()){
                    return;
                }
                let me = this;
                axios.post('/user/registrar', {
                    'nombre' : this.nombre,
                    'numero_documento' : this.numero_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idrol' : this.idrol,
                    'idsucursal' : this.idsucursal
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
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
                    'idsucursal' : this.idsucursal,
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
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona = [];

                if(!this.nombre) this.errorMostrarMsjPersona.push("El nombre no puede estar vacío.");
                if(!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if(!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
                if(this.idrol == 0) this.errorMostrarMsjPersona.push("Debe seleccionar un rol para el usuario.");
                if(this.idsucursal == 0) this.errorMostrarMsjPersona.push("Debe seleccionar una sucursal para el usuario.");
                if(this.errorMostrarMsjPersona.length) this.errorPersona= 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.numero_documento = '';
                this.direccion = '';
                this.telefono = '';
                this.email = '';
                this.usuario = '';
                this.password = '';
                this.idrol = 0;
                this.idsucursal = 0;
                this.errorPersona = 0;
            },
            abrirModal(modelo, accion, data =[]){
                this.selectRol();
                this.selectSucursal();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.nombre = '';
                                this.numero_documento = '';
                                this.direccion = '';
                                this.telefono = '';
                                this.email = '';
                                this.usuario = '';
                                this.password = '';
                                this.idrol = 0;
                                this.idsucursal = 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Usuario';
                                this.tipoAccion = 2;
                                this.persona_id = data['id'];
                                this.nombre = data['nombre'];
                                this.numero_documento = data['numero_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password = data['password'];
                                this.idrol = data['idrol'];
                                this.idsucursal = data['idsucursal'];
                                break;
                            }
                        }
                    }
                }
            }
            ,
        desactivarUsuario(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar esta usuario?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/user/desactivar',{
                        'id' : id
                    }).then(function (response){
                        me.listarPersona(1,'','nombre');
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El usuario ha sido desctivado con éxito.',
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
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
    .card-headerr{
        background-color: #013252;
        color:white;
        font-weight: 800;
    }
</style>
