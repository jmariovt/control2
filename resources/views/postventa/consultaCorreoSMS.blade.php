
@extends('layouts.apppostventa')


@section('content')
@include('common.success')
@include('common.errors')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Consulta Correo y Celular</div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="col-md-4">
                                                    <input class="form-control form-control-sm" type="text" name="consultaCorreoCelularBuscar" id="consultaCorreoCelularBuscar" placeholder="Buscar correo o celular">
                                                    <button type="button" class="btn btn-info btn-sm" id="btConsultaCorreoCelular" name="btConsultaCorreoCelular">Consultar</button>
                                                </div>
                                            </td>
                                            
                                            
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <table id="ConsultaCorreoCelularTabla" class="display"  style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Usuario</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Celular</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Usuario</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Celular</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection