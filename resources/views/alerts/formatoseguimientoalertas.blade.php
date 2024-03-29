
<table>
    <tbody>
        <tr>
            <td >Total Alertas Generadas: {{$totalAlertasGeneradas}}</td>
        </tr>
        <tr>
            <td >Total Alertas Contestadas: {{$totalAlertasContestadas}}</td>
        </tr>
        <tr>
            <td >Promedio Alertas Contestadas: {{$promedioAlertasContestadas}}</td>
        </tr>
        <tr>
            <td >Tiempo Respuesta Promedio: {{$tiempoRespuestaPromedio}}</td>
        </tr>
        <tr>
            <td >Prom. Robos: {{$promRobos}} Prom. Casos Enviados: {{$promCasosEnviados}} Prom. Repetidas: {{$promRepetidas}}</td>
        </tr>
        <tr>
            <td >Total Alertas Contestadas x Agente: {{$totalAlertasContestadasAgente}}</td>
        </tr>
        <tr>
            <td >Promedio Alertas Contestadas x Agente: {{$promAlertasContestadasAgente}}</td>
        </tr>
        <tr>
            <td >Promedio Alertas Total Contestadas x Agente: {{$promAlertasTotalContestadasAgente}}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td>Nombre Cliente</td>
            @if($idSubUsuario=="0")
                <td>VID</td>
                <td>CodSysHunter</td>
            @endif
            <td>Alias</td>
            <td>Producto</td>
            <td>Dispositivo</td>
            <td>Alerta</td>
            <td>Estado de Alerta</td>
            <td>Fecha Ocurrencia</td>
            <td>Fecha Gestión</td>
            <td>Agente Gestión</td>
            <td>Gestión</td>
            <td>Motivo Alerta</td>
            @if($idSubUsuario!="0")
                <td>ID Cliente</td>
            @endif
        </tr>
        @foreach($alertas as $alerta)
        <tr>
            <td>{{$alerta->NombreCliente}}</td>
            @if($idSubUsuario=="0")
                <td>{{$alerta->VID}}</td>
                <td>{{$alerta->CodSysHunter}}</td>
            @endif
            <td>{{$alerta->Alias}}</td>
            <td>{{$alerta->Producto}}</td>
            <td>{{$alerta->Dispositivo}}</td>
            <td>{{$alerta->Alerta}}</td>
            <td>{{$alerta->EstadoAlarma}}</td>
            <td>{{$alerta->FechaOcurrencia}}</td>
            <td>{{$alerta->FechaGestion}}</td> 
            <td>{{$alerta->NombreAgente}}</td>
            <td>{{$alerta->Gestion}}</td>
            <td>{{$alerta->MotivoAlerta}}</td>
            @if($idSubUsuario!="0")
                <td>{{$alerta->client_id}}</td>
            @endif
        </tr>
        
        @endforeach
    </tbody>

</table>
