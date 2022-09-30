@extends('layouts.apppostventa')
@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Detalle de SMS para {{$numero??''}}
                    </br>
                    Desde {{$fechaDesde??''}} Hasta {{$fechaHasta??''}}
                    </br>
                    Total: {{$total}}
                </div>
                

                <div class="card-body">
                    <div class="container">
	    				<div class="row justify-content-center">
                            <form class="form-group" method="POST" action="/xadmin/postventa/grabarModificarAlias">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSNumero" name="detalleSMSNumero" value="{{$numero}}">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSFechaDesde" name="detalleSMSFechaDesde" value="{{$fechaDesde}}">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSFechaHasta" name="detalleSMSFechaHasta" value="{{$fechaHasta}}">
                            <input class="form-control form-control-sm" type="hidden" id="detalleSMSTipo" name="detalleSMSTipo" value="{{$tipo}}">
                            
                            @csrf
                                <table id="DetalleSMSTabla" class="display"  style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>VID</th>
                                            <th>Cantidad</th>
                                            <th>Placa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registros as $registro)
                                        <tr>
                                            <td>
                                                {{$registro->VID}}
                                            </td>
                                            <td>
                                                {{$registro->CANTIDAD}}
                                            </td>
                                            <td>
                                                {{$registro->Alias}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>VID</th>
                                            <th>Cantidad</th>
                                            <th>Placa</th>
                                        </tr>
                                    </tfoot>
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