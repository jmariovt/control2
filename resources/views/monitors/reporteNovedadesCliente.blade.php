<table>
    <thead>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <th colspan="9" rowspan="1">NOVEDADES EN EL MONITOREO DE EVENTOS {{$UsuarioControl}}</th>
    </tr>
    <tr><td>&nbsp;</td></tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" >Fecha de Informe:</td>
        </tr>
        <tr>
            <td>Desde:</td>
            <td >{{$fechaDesde}}</td>
            <td>Hasta:</td>
            <td >{{$fechaHasta}}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                FECHA/HORA
            </td>
        
            <td>
                COMPAÑÍA
            </td>
       
            <td>
                PRODUCTO
            </td>
        
            <td>
                CONDUCTOR
            </td>
        
            <td>
                NOVEDAD
            </td>
       
            <td>
                DETALLE
            </td>
       
            <td>
                TEMPERATURA
            </td>
       
            <td>
                ORIGEN
            </td>
            <td>
                DESTINO
            </td>
        </tr>
        @foreach($novedades as $novedad)
        <tr>
            <td>{{$novedad->Fecha}}</td>
            <td>{{$novedad->Compania}}</td>
            
            <td>{{$novedad->Producto}}</td>
            <td>{{$novedad->Conductor}}</td>
            <td>{{$novedad->Novedad}}</td>
            <td>{{$novedad->Detalle}}</td>
            <td>{{$novedad->Temperatura}}</td>
            <td>{{$novedad->Origen}}</td>
            <td>{{$novedad->Destino}}</td>
            
        </tr>
        @endforeach
        
    </tbody>
</table>