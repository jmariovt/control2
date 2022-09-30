
<table>
    <tbody>
        <tr>
            <td >Desde: {{$fechaDesde}}</td>
        </tr>
        <tr>
            <td >Hasta: {{$fechaHasta}}</td>
        </tr>
        <tr>
            <td >Agente: {{$agente}}</td>
        </tr>
        <tr>
            <td >Grupo: {{$grupo}}</td>
        </tr>
        
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td>Tipo</td>
            
            <td>Alertas generadas</td><td>Alertas gestionadas</td><td>Alertas gestionadas por otro</td><td>Alertas sin gestionar</td>
            <td>Tiempo promedio de respuesta meta</td><td>Tiempo promedio de respuesta real</td><td>Eficiencia</td><td>Eficacia</td>
            
        </tr>
        @foreach($alertasAgrupadas as $key => $alerta)
        <?php
        if(strlen($key)>0)
        {
        ?>
            <tr>
                
                <td>{{$key}}</td>
                <?php try {
                ?>
                <td>{{$alerta['G']  ?? 0}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                <?php try {
                ?>
                <td>{{$alerta['A'] ?? 0}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                <?php try {
                ?>
                <td>{{$alerta['APO'] ?? 0}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                
                <?php try {
                ?>
                <td>{{$alerta['NA'] ?? 0}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                <td>10</td>
                <?php try {
                ?>
                <td>{{$alerta['TP'] ?? 0}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                <?php try {
                ?>
                <td>{{$alerta['EFICIENCIA']}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                <?php try {
                ?>
                <td>{{$alerta['EFICACIA']}}</td>
                <?php
                } catch (\Throwable $th) {
                ?><td>0</td>
                <?php
                }
                ?>
                
            </tr>
        <?php
        }
        ?>
        
        @endforeach
    </tbody>

</table>
