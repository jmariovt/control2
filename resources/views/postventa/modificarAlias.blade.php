@extends('layouts.apppostventa')
@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Cambio de Alias

                </div>

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
                            <form class="form-group" method="POST" action="/xadmin/postventa/grabarModificarAlias">
                            @csrf
                                <table>
                                    <tr>
                                        <td>
                                            Alias anterior
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text" id="AliasAnterior" name="AliasAnterior" value="{{$Alias}}" disabled>
                                            <input class="form-control form-control-sm" type="hidden" id="IdActivo" name="IdActivo" value="{{$IdActivo}}">
                                            <input class="form-control form-control-sm" type="hidden" id="IdUsuario" name="IdUsuario" value="{{$IdUsuario}}">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nuevo Alias
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text" id="NuevoAlias" name="NuevoAlias">
                                        </td>
                                        <td>
                                            <a href="" onclick="window.close();" class="btn btn-secondary btn-sm">Cancelar</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Etiqueta anterior
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text" id="EtiquetaAnterior" name="EtiquetaAnterior" value="{{$Etiqueta??''}}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nueva Etiqueta
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="text" id="NuevaEtiqueta" name="NuevaEtiqueta">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection