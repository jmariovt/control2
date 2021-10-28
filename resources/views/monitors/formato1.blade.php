<table>
    <thead>
    <tr>
        <th colspan="7" rowspan="2">INFORME DE MONITOREO</th>
    </tr>
    <tr><td>&nbsp;</td></tr>
    </thead>
    <tbody>
        <tr>
            <td>COMPAÑÍA</td>
            <td colspan="2">{{strtoupper($infoAdicional->Compania)}}</td>
            <td>FECHA INFORME</td>
            <td colspan="2">{{$infoAdicional->FechaInforme}}</td>
            <td rowspan="9">&nbsp;</td>
            
        </tr>
        <tr>
            <td>VEHÍCULO</td>
            <td colspan="2">{{strtoupper($infoAdicional->Vehiculo)}}</td>
            <td>VID VEHÍCULO</td>
            <td colspan="2">{{$infoAdicional->VID}}</td>
        </tr>
        <tr>
            <td>PLACA</td>
            <td colspan="2">{{strtoupper($infoAdicional->Placa)}}</td>
            <td>FECHA DE SALIDA</td>
            <td colspan="2">{{$infoAdicional->FechaSalida}}</td>
        </tr>
        <tr>
            <td>FECHA DE SALIDA PROGRAMADA</td>
            <td colspan="2">{{$infoAdicional->FechaSalidaProgramada}}</td>
            <td>HORA DE SALIDA</td>
            <td colspan="2">{{$infoAdicional->HoraSalida}}</td>
        </tr>
        <tr>
            <td>LUGAR DE SALIDA</td>
            <td colspan="2">{{strtoupper($infoAdicional->LugarSalida)}}</td>
            <td>FECHA FIN DE MONITOREO</td>
            <td colspan="2">{{$infoAdicional->FechaFinMonitoreo}}</td>
        </tr>
        <tr>
            <td>LUGAR DE LLEGADA</td>
            <td colspan="2">{{strtoupper($infoAdicional->LugarLlegada)}}</td>
            <td>HORA FIN DE MONITOREO</td>
            <td colspan="2">{{$infoAdicional->HoraFinMonitoreo}}</td>
        </tr>
        <tr>
            <td>CHOFER</td>
            <td colspan="2">{{strtoupper($infoAdicional->Chofer)}}</td>
            <td>CELULAR</td>
            <td colspan="2">{{$infoAdicional->ChoferCelular}}</td>
        </tr>
        <tr>
            <td>OFICIAL/OTROS</td>
            <td colspan="2">{{strtoupper($infoAdicional->Oficial)}}</td>
            <td>CELULAR</td>
            <td colspan="2">{{$infoAdicional->OficialCelular}}</td>
        </tr>
        <tr>
            <td>CONTENEDOR N°</td>
            <td colspan="2"></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td>
                FECHA
            </td>
        
            <td>
                HORA
            </td>
       
            <td>
                LUGAR
            </td>
        
            <td>
                DETENIDO
            </td>
        
            <td>
                LLAMADA
            </td>
       
            <td>
                TEMPERATURA
            </td>
       
            <td>
                NOVEDAD
            </td>
       
            <!--<td>
                KILOMETRAJE
            </td>-->
        </tr>
        @foreach($monitors as $monitor)
        <tr>
            <td>{{$monitor->Fecha}}</td>
            <td>{{$monitor->Hora}}</td>
            <td>{{strtoupper($monitor->Lugar)}}</td>
            <td>{{$monitor->Detenido}}</td>
            <td>{{$monitor->Llamada}}</td>
            <?php 
                if($monitor->Temperatura==0)
                    $temperatura = "N/A";
                else 
                    $temperatura = $monitor->Temperatura."°C"; 
                
            ?>
            <td>{{$temperatura}}</td>
            <?php
                $novedadArray = explode("\\",$monitor->Novedad);
                $novedad = $novedadArray[0];
            ?>
            <td><br />{{strtoupper($novedad)}}</td>
            <!--<td>{{$monitor->Kilometraje}}</td>-->
        </tr>
        @endforeach
        
    </tbody>
</table>