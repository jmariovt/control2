<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EGadmin') }}</title>

    <!-- CSS only -->
    
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">-->
     <!-- TEMA DE BOOTSTRAP --> 
      <!--  <link rel="stylesheet" href="https://bootswatch.com/4/slate/bootstrap.css">-->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('js/jquery.datetimepicker.min.css') }}">

        <!-- JS, Popper.js, and jQuery -->
    
    <script src="{{asset('js/jquery-3.5.1.js')}}" type="text/javascript"></script>
    <!--<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>-->
    <script src="{{asset('jqueryui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
    <script src="{{asset('js/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

    <!-- Fonts -->
    <!--<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <!-- Styles 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    <!-- CSS Agregado para autocompletar-->
    <link rel="stylesheet" type="text/css" href="{{asset('jqueryui/jquery-ui.min.css')}}">
       
    <link rel="stylesheet" type="text/css" href="{{asset('css/listbox.css')}}">
    
    <!-- Este estilo es para la tabla principal de los montoreos -->
    <style type="text/css">
        .table-condensed{
            font-size: 9px;
            }
    </style>



    


</head>
<body>
    <div id="app" >
        <div class="container">
        @include('common.success')
        @include('common.errors')
            <form class="form-group" method="POST" action="/xadmin/monitors/exportReportesCliente">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Reportes</div>

                            <div class="card-body">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <input class="form-control form-control-sm" type="hidden" id="UsuarioControl" name="UsuarioControl" value='{{$UsuarioControl}}'>
                                        <input class="form-control form-control-sm" type="hidden" id="alias" name="alias" value=''>
                                        <table class="table table-sm table-hover table-striped">
                                            <tbody>
                                                <tr>
                                                    <td >Buscar:</td>
                                                    <td>
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm" type="text" placeholder="Desde" id="informeFechaDesde" name="informeFechaDesde"  autocomplete="off" >
                                                    </div>
                                                    </td>

                                                    
                                                    <td>
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm"  type="text" placeholder="Hasta" id="informeFechaHasta" name="informeFechaHasta"   autocomplete="off" >
                                                    </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1">Tipo de reporte:</td>
                                                    <td>
                                                    <div class="form-group">
                                                    <select class="form-control form-control-sm" id="tipoReporte" name="tipoReporte">
                                                        <option value="1" selected>Novedades</option>
                                                        <!--<option value="2">Condensado</option>-->
                                                    </select>
                                                    </div>
                                                    </td>
                                                    <td colspan="1">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1">&nbsp;</td>

                                                    <td><button type="submit" class="btn btn-primary btn-sm">Generar</button></td>
                                                    
                                                    <td colspan="1">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script type="text/javascript" src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function(){
        $('#informeFechaDesde').datetimepicker({
            useCurrent: true,
            format: 'd/m/Y',//'Ymd',
            changeYear: false,
            minDate: 1,
            onShow: function(ct) {
                
                }
            
            
        })

        $('#informeFechaHasta').datetimepicker({
            useCurrent: true, //Important! See issue #1075
            format: 'd/m/Y',
            onShow: function(ct) 
            {
               
            }
            
        })
   });

        


   
</script>
</html>