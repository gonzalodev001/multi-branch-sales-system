<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }

        #fech{
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 15px;
        }
    </style>
    <body>
        @foreach ($servicio as $v)
        <header>
            <div id="logo">
                <img src="img/nextec.png" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Emec</b><br>Ostria Gutierrez 520, Chuquisaca - Sucre<br>Telefono:(+51)6463345<br>Email:emec@gmail.com
                </p>
            </div>
            <div id="fact">
                <br><br>
                <p>Número de servicio técnico<br>
                {{$v->id}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Sr(a). {{$v->nombre}}<br>
                            NIT/CI: {{$v->numero_documento}}<br>
                            Dirección: {{$v->direccion}}<br>
                            Teléfono: {{$v->telefono}}<br>
                            Email: {{$v->email}}</</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VENDEDOR</th>
                            <th>FECHA ENTRADA</th>
                            <th>FECHA SALIDA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="fech">
                            <td>{{$v->usuario}}</td>
                            <td>{{$v->fecha_hora}}</td>
                            <td>{{$v->fecha_hora_salida}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>
                        <tr id="fac">
                            <th>DESCRIPCION DE EQUIPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>{{$v->descipcion_equipo}}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <div>
                <table id="facliente">
                    <thead>
                        <tr id="fa">
                            <th>DEFECTOS DE EQUIPO</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>{{$v->defectos_entrada}}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </section>
        <section>
            <div>
                <table id="facliente">
                    <thead>
                        <tr id="fa">
                            <th>DEFECTOS Y SOLUCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>{{$v->defectos_salida}}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su preferencia!</b></p>
            </div>
        </footer>
    </body>
</html>