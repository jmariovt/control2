
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
        @foreach($alertas as $alerta)
        <tr>
            <td>{{$alerta->NombreAgente}}</td>
            
        </tr>
        
        @endforeach
    </tbody>

</table>
