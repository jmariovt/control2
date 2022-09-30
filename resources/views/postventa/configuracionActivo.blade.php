@extends('layouts.apppostventa')
@section('content')
@include('common.success')
@include('common.errors')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Configuración de activo

                </div>
                <div class="card-body">
                    <form class="form-group" action="/xadmin/postventa/actualizarConfiguracionActivo" method="POST">
                    @csrf
                        <div class="container-fluid">
                            <input class="form-control form-control-sm" type="hidden" id="IdActivo" name="IdActivo" value="{{$IdActivo}}"> 
                            <input class="form-control form-control-sm" type="hidden" id="IdUsuario" name="IdUsuario" value="{{$IdUsuario}}"> 
                            
                            <div class="row justify-content-center">
                                <div class="tabbable boxed parentTabs">

                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#configuracion" id="navconfiguracion">Configuración</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#fotos" id="navfotos">Fotos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#entrada1" id="naventrada1">Entrada 1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#entrada2" id="naventrada2">Entrada 2</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#entrada3" id="naventrada3">Entrada 3</a>
                                        </li>
                                            
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div class="tab-pane fade active show" id="configuracion" name="configuracion">
                                            <div id="divConfig">
                                                <label for="Alias">Placa/Alias</label>
                                                <input class="form-control form-control-sm" type="text" id="Alias" name="Alias" value="{{$placa}}">
                                                <label for="Actividad">Actividad asignada</label>
                                                <input class="form-control form-control-sm" type="text" id="Actividad" name="Actividad" value="{{$configuracion->ActividadActivo ?? ' '}}">
                                                <label for="Consumo">Consumo Promedio Km/Gal</label>
                                                <input class="form-control form-control-sm" type="text" id="ConsumoPromedio" name="ConsumoPromedio" value="{{$configuracion->ConsumoPromedio ?? ' '}}">
                                                <input class="form-control form-control-sm" type="hidden" id="UnidadConsumo" name="UnidadConsumo" value="{{$configuracion->UnidadConsumo ?? ' '}}">
                                                <label for="Chofer">Chofer Actual</label>
                                                <select class="form-control-sm" id="Chofer" name="Chofer">
                                                <option value='0' >Elija chofer</option>
                                                    @foreach($choferes as $chofer)
                                                    <?php
                                                        $selected = "";
                                                        if($chofer->Codigo==$idChoferActual)
                                                            $selected = "selected";
                                                    ?>
                                                    <option value='{{ $chofer->Codigo ?? "0" }}' {{$selected}} >{{ $chofer->Descripcion ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="fotos" name="fotos">
                                            <div id="divFotos">
                                                <p>Fotos</p>
                                            </div>
                                        
                                        </div>
                                        <div class="tab-pane fade" id="entrada1" name="entrada1">
                                            <div id="divEntrada1">
                                                <label for="Etiqueta1">Etiqueta campo 1</label>
                                                <input class="form-control form-control-sm" type="text" id="Etiqueta1" name="Etiqueta1" value="{{$configuracion->EA1_Etiqueta ?? ''}}">
                                                <label for="Unidad1">Unidad de Medición 1</label>
                                                <input class="form-control form-control-sm" type="text" id="Unidad1" name="Unidad1" value="{{$configuracion->EA1_Unidad ?? ''}}">
                                                <table>
                                                    <tr>
                                                        <td colspan="3">Rango Valores 1</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="RangoMin1">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMin1" name="RangoMin1" value="{{$configuracion->EA1_RangoMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="RangoMax1">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMax1" name="RangoMax1" value="{{$configuracion->EA1_RangoMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Escala Valores 1</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="EscalaMin1">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMin1" name="EscalaMin1" value="{{$configuracion->EA1_EscalaMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="EscalaMax1">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMax1" name="EscalaMax1" value="{{$configuracion->EA1_EscalaMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        
                                        </div>
                                        <div class="tab-pane fade" id="entrada2" name="entrada2">
                                            <div id="divEntrada2">
                                                <label for="Etiqueta2">Etiqueta campo 2</label>
                                                <input class="form-control form-control-sm" type="text" id="Etiqueta2" name="Etiqueta2" value="{{$configuracion->EA2_Etiqueta ?? ''}}">
                                                <label for="Unidad1">Unidad de Medición 2</label>
                                                <input class="form-control form-control-sm" type="text" id="Unidad2" name="Unidad2" value="{{$configuracion->EA2_Unidad ?? ''}}">
                                                <table>
                                                    <tr>
                                                        <td colspan="3">Rango Valores 2</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="RangoMin2">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMin2" name="RangoMin2" value="{{$configuracion->EA2_RangoMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="RangoMax2">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMax2" name="RangoMax2" value="{{$configuracion->EA2_RangoMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Escala Valores 2</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="EscalaMin2">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMin2" name="EscalaMin2" value="{{$configuracion->EA2_EscalaMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="EscalaMax2">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMax2" name="EscalaMax2" value="{{$configuracion->EA2_EscalaMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        
                                        </div>
                                        <div class="tab-pane fade" id="entrada3" name="entrada3">
                                            <div id="divEntrada3">
                                                <label for="Etiqueta3">Etiqueta campo 3</label>
                                                <input class="form-control form-control-sm" type="text" id="Etiqueta3" name="Etiqueta3" value="{{$configuracion->EA3_Etiqueta ?? ''}}">
                                                <label for="Unidad1">Unidad de Medición 3</label>
                                                <input class="form-control form-control-sm" type="text" id="Unidad3" name="Unidad3" value="{{$configuracion->EA3_Unidad ?? ''}}">
                                                <table>
                                                    <tr>
                                                        <td colspan="3">Rango Valores 3</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="RangoMin3">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMin3" name="RangoMin3" value="{{$configuracion->EA3_RangoMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="RangoMax3">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="RangoMax3" name="RangoMax3" value="{{$configuracion->EA3_RangoMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Escala Valores 3</td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            <label for="EscalaMin3">Min</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMin3" name="EscalaMin3" value="{{$configuracion->EA3_EscalaMin ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <label for="EscalaMax3">Máx</label>
                                                            <input class="form-control form-control-sm" type="text" id="EscalaMax3" name="EscalaMax3" value="{{$configuracion->EA3_EscalaMax ?? ''}}">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>   
                                
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection