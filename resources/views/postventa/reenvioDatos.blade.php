@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Reenvío de Datos

                </div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">

                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#porUnidad" id="navporunidad">Por Unidad</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#porUsuario" id="navporusuario">Por Usuarios</a>
                                </li>
                               
                            </ul>
							<div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active show" id="porUnidad" name="porUnidad">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="VID" id="vidReenvioDatosBuscar" name="vidReenvioDatosBuscar" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="consultaGeneralDatosEncontrados" name="consultaGeneralDatosEncontrados" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="Usuario" name="Usuario" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="IdEntidad" name="IdEntidad" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="UID" name="UID" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="UsuarioSesion" name="UsuarioSesion" value=''>
                                                </td>
                                                
                                                <!--<td>
                                                    <button class="btn btn-secondary btn-sm" type="button" id="btnLimpiarReenvioDatos" name="btnLimpiarReenvioDatos">Limpiar</button>
                                                </td>-->
                                                                                    
                                                <td>
                                                <!--    <button class="btn btn-primary btn-sm" type="button" id="btnGrabarCambios" name="btnGrabarCambios">Grabar Cambios</button>-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-sm table-striped">
                                        <tbody>
                                            <tr>
                                                <td >Placa:</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text"  id="reenvioDatosPlaca" name="reenvioDatosPlaca" value='' disabled>
                                                </td>
                                                <td >Último Reporte:</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text"  id="reenvioDatosUltimoReporte" name="reenvioDatosUltimoReporte" value='' disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >Protocolo:</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text"  id="reenvioDatosProtocolo" name="reenvioDatosProtocolo" value='' disabled>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                    </table>
                                    <div class="col-sm-6">
                                        
                                        <ul class="columns">

                                            <li class="column servidoresDisponiblesColumn">
                                                <div class="column-header">
                                                    <h4>Servidores Disponibles</h4>
                                                </div>
                                                <ul class="task-list" id="to-do">
                                              
                                                </ul>
                                            </li>

                                            <li class="column servidoresRegistradosColumn">
                                                <div class="column-header">
                                                    <h4>Servidores Registrados</h4>
                                                </div>
                                                <ul class="task-list" id="trash">
                                                   

                                                </ul>
                                                <div class="column-button">
                                                    <!--<button class="button delete-button" onclick="emptyTrash()">Borrar</button>-->
                                                    <button class="btn btn-primary btn-sm" type="button" id="btnGrabarCambios" name="btnGrabarCambios">Grabar Cambios</button>
                                                </div>
                                            
                                            </li>

                                        </ul>
                                       
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="porUsuario" name="porUsuario">
                                <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                
                                                <td>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Usuario" id="usuarioReenvioDatosBuscar" name="usuarioReenvioDatosBuscar" value=''>
                                                    <input class="form-control form-control-sm" type="hidden"  id="IdUsuario" name="IdUsuario" value='0'>
                                                    
                                                </td>
                                                
                                                <!--<td>
                                                    <button class="btn btn-info btn-sm"  type="button" id="btnLimpiarReenvioDatosPorUsuario" name="btnLimpiarReenvioDatosPorUsuario">Limpiar</button>
                                                </td>-->
                                                                                    
                                                <td>
                                                    <!--<button class="btn btn-primary btn-sm" type="button" id="btnGrabarCambiosPorUsuario" name="btnGrabarCambiosPorUsuario">Grabar Cambios</button>-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-sm table-striped">
                                        <tbody>
                                            <tr>
                                                <td >Nombres:</td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="text"  id="reenvioDatosNombres" name="reenvioDatosNombres" value='' disabled>
                                                </td>
                                                
                                            </tr>
                                            
                                    </table>
                                    <div class="col-sm-6">
                                        
                                        <ul class="columns">

                                            <li class="column servidoresDisponiblesColumn">
                                                <div class="column-header">
                                                    <h4>Servidores Disponibles</h4>
                                                </div>
                                                <ul class="task-list" id="to-do2">
                                              
                                                </ul>
                                            </li>

                                            <li class="column servidoresRegistradosColumn">
                                                <div class="column-header">
                                                    <h4>Servidores Registrados</h4>
                                                </div>
                                                <ul class="task-list" id="trash2">
                                                   

                                                </ul>
                                                <div class="column-button">
                                                    <!--<button class="button delete-button" onclick="emptyTrash()">Borrar</button>-->
                                                    <button class="btn btn-primary btn-sm" type="button" id="btnGrabarCambiosPorUsuario" name="btnGrabarCambiosPorUsuario">Grabar Cambios</button>
                                                </div>
                                            
                                            </li>

                                        </ul>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection