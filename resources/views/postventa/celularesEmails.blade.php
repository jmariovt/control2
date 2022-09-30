@extends('layouts.apppostventa')

@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Celulares y Correos Electrónicos

                </div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
							
	    					<table class="table table-sm">
	    						<tbody>
				                    <tr>
				                        <td >Buscar:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text" placeholder="Cedula, RUC, nombre, razón social o usuario GeoSys" id="celularesEmailBuscar" name="celularesEmailBuscar" value="{{old('celularesEmailBuscar')}}">
                                            <input class="form-control form-control-sm" type="hidden"  id="consultaGeneralDatosEncontrados" name="consultaGeneralDatosEncontrados" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="IdUsuario" name="IdUsuario" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="Usuario" name="Usuario" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="IdEntidad" name="IdEntidad" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="UID" name="UID" value=''>
                                            <input class="form-control form-control-sm" type="hidden"  id="UsuarioSesion" name="UsuarioSesion" value=''>
				                        </td>
                                        <td>
                                            <div class="form-group row">
                                                
                                                <div class="col-md-6">
                                                    <select class="form-select  form-select-sm" id="consultaGeneralCriterio" name="consultaGeneralCriterio">
                                                        <option value='0'>Cédula o RUC</option>
                                                        <option value='1'>Nombre completo o razón social</option>
                                                        <option value='4' selected>Usuario GeoSys</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-secundary btn-sm" type="button" id="btnEncerarCelularesEmail" name="btnEncerarCelularesEmail">Limpiar</button>
                                        </td>
                                        
                                        
                                       
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-striped">
	    						<tbody>
				                    <tr>
				                        <td >Nombres o Razón Social:</td>
				                        <td>
				                        	<input class="form-control form-control-sm" type="text"  id="celularesEmailNombres" name="celularesEmailNombres" value='' disabled>
				                        </td>
                                        
                                    </tr>
                                    
                                    
                                </tbody>
                            </table>

                            <div class="col-sm-6">
                                <button class="btn btn-primary btn-sm" id="btnNuevoCelular">Nuevo Celular</button>
                                </p>
                                <div id="areaCelular" style="display: none;">
                                    <table id="tablaAreaCelular">
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Número" id="nuevoCelularNumero" name="nuevoCelularNumero" value=''>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Propietario" id="nuevoCelularPropietario" name="nuevoCelularPropietario" value=''>
                                                <input class="form-control form-control-sm" type="hidden" id="nuevoCelularOperacion" name="nuevoCelularOperacion" value='N'>
                                                <input class="form-control form-control-sm" type="hidden" id="antiguoCelular" name="antiguoCelular" value=''>
                                            </td>
                                            <td>
                                                <select class="form-control-sm" id="nuevoCelularOperadora" name="nuevoCelularOperadora">
                                                    <option value='0' selected>Operadora...</option>
                                                    <option value='1'>Claro</option>
                                                    <option value='2'>Movistar</option>
                                                    <option value='4'>Indeterminada</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a id="guardarCelular" ><img src="../Imagenes/floppy-disk-solid.svg"  title="Guardar"  style="height: 20px;"/></a>
                                            </td>
                                        </tr>
                                    </table>
                                
                                
                                </div>

                                <table class="table table-sm table-hover table-striped" id="tablaCelulares">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Celular</th>
                                            <th>Propietario</th>
                                            <th>Operadora</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyCelulares" id="tbodyCelulares">
                                        
                                        
                                        
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-sm-6">
                                <button class="btn btn-primary btn-sm" id="btnNuevoCorreo" name="btnNuevoCorreo">Nuevo Correo</button>
                                </p>
                                <div id="areaCorreo" style="display: none;">
                                    <table id="tablaAreaCorreo">
                                        <tr>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Correo electrónico" id="nuevoCorreoCorreo" name="nuevoCorreoCorreo" value=''>
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" placeholder="Propietario" id="nuevoCorreoPropietario" name="nuevoCorreoPropietario" value=''>
                                                <input class="form-control form-control-sm" type="hidden" id="nuevoCorreoOperacion" name="nuevoCorreoOperacion" value='N'>
                                                <input class="form-control form-control-sm" type="hidden" id="antiguoCorreo" name="antiguoCorreo" value=''>
                                            </td>
                                            <td>
                                                <a  id="guardarCorreo"><img src="../Imagenes/floppy-disk-solid.svg"  title="Guardar"  style="height: 20px;"/></a>
                                            </td>
                                        </tr>
                                    </table>
                                
                                
                                </div>
                                <table class="table table-sm table-hover table-striped" id="tablaCorreos">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Correo Electrónico</th>
                                            <th>Propietario</th>
                                            <th colspan="2">&nbsp;</th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody name="tbodyCorreo" id="tbodyCorreo">
                                        
                                        
                                        
                                        
                                    </tbody>
                                </table>
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <!--<div style="overflow-x:auto;">-->
                           
                        <!--</div>-->



	    				
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection