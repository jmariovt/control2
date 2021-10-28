<table>
    <thead>
    <tr>
        <th colspan="7" rowspan="2">HOJA DE RUTA MONITOREO</th>
    </tr>
    <tr><td>&nbsp;</td></tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2">Nombre del cliente:</td>
            <td colspan="6" rowspan="2">{{$datosCliente[0]->Compania}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2"># de candado asignado:</td>
            <td colspan="6" rowspan="2">{{$datosCliente[0]->NumeroCandado}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Datos Contenedor:</td>
            <td rowspan="2">Número:</td>
            <td rowspan="2">{{$datosCliente[0]->NumeroContenedor}}</td>
            <td rowspan="2">Pies:</td>
            <td rowspan="2">{{$datosCliente[0]->PiesContenedor}}</td>
            <td rowspan="2">Tipo carga:</td>
            <td rowspan="2">{{$datosCliente[0]->TipoCargaContenedor}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Datos vehículo:</td>
            <td rowspan="2">Placa:</td>
            <td rowspan="2">{{$datosCliente[0]->Placa}}</td>
            <td rowspan="2">Marca:</td>
            <td rowspan="2">{{$datosCliente[0]->Marca}}</td>
            <td rowspan="2">Color:</td>
            <td rowspan="2">{{$datosCliente[0]->Color}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Nombre y celular de chofer:</td>
            <td colspan="4" rowspan="2">{{$datosCliente[0]->NombreChofer}}</td>
            <td colspan="2" rowspan="2">{{$datosCliente[0]->CelularChofer}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Nombre y celular de acompañante:</td>
            <td colspan="4" rowspan="2">{{$datosCliente[0]->NombreAcompanante}}</td>
            <td colspan="2" rowspan="2">{{$datosCliente[0]->CelularAcompanante}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Ruta a seguir:</td>
            <td colspan="6" rowspan="2">{{$datosCliente[0]->Ruta}}</td>
           
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="7" rowspan="2">ORIGEN</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Fecha y hora:</td>
            <td colspan="6" rowspan="2">{{$datosCliente[0]->FechaHoraInicio}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <?php
            $arreglo_direccion_origen = explode(' - ',$datosCliente[0]->DireccionOrigen);
        ?>
        <tr>
            <td rowspan="2">Ciudad y Lugar:</td>
            <td colspan="6" rowspan="2">{{$arreglo_direccion_origen[0]}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Dirección:</td>
            <td colspan="6" rowspan="2">{{$arreglo_direccion_origen[1]}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="7" rowspan="2">DESTINO</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Fecha y hora:</td>
            <td colspan="6" rowspan="2">{{$datosCliente[0]->FechaHoraFin}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <?php
            $arreglo_direccion_destino = explode(' - ',$datosCliente[0]->DireccionDestino);
        ?>
        <tr>
            <td rowspan="2">Ciudad y Lugar:</td>
            <td colspan="6" rowspan="2">{{$arreglo_direccion_destino[0]}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">Dirección:</td>
            <td colspan="6" rowspan="2">{{$arreglo_direccion_destino[1]}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="7" rowspan="2">CONTACTOS PARA INFORMAR DEL RECORRIDO DURANTE EL MONITOREO</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <?php

            $arreglo_contactos = explode('%',$datosCliente[0]->ContactosRecorrido);
            $conteo = 0;
        ?>
        @foreach($arreglo_contactos as $contacto)
            <?php
                $arreglo_contacto = explode(' - ',$contacto);
                $conteo = $conteo + 1;
            ?>
            <tr>
                <td>{{$conteo}}.- Nombre:</td>
                <td colspan="6">{{$arreglo_contacto[0]}}</td>
            </tr>
            <tr>
                <td >Email:</td>
                <td colspan="6">{{$arreglo_contacto[1]}}</td>
            </tr>
            <tr>
                <td colspan="7">&nbsp;</td>
            </tr>
        @endforeach
        
        
        
        <tr>
            <td colspan="7" rowspan="2">PARADAS PERMITIDAS</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <?php

            $arreglo_paradas = explode('%',$datosCliente[0]->ParadasPermitidas);
            $conteo = 0;
        ?>
        @foreach($arreglo_paradas as $parada)
            <?php
                $arreglo_parada = explode(' - ',$parada);
                $conteo = $conteo + 1;
            ?>
            <tr>
                <td>{{$conteo}}.- Lugar:</td>
                <td colspan="6">{{$arreglo_parada[0]}}</td>
            </tr>
            <tr>
                <td >Tiempo:</td>
                <td colspan="6">{{$arreglo_parada[1]}}</td>
            </tr>
            <tr>
                <td colspan="7">&nbsp;</td>
            </tr>
        @endforeach



       
        <tr>
            <td colspan="7" rowspan="2">EN CASO DE EVENTUALIDADES CONTACTAR A</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        @foreach($planesAccion as $planAccion)
            <tr>
                <td>{{$planAccion->Secuencia}}.- Nombre:</td>
                <td colspan="6">{{$planAccion->Detalle}}</td>
            </tr>
            <?php
                $arreglo_observaciones = explode(' ',$planAccion->Observaciones);
            ?>
            <tr>
                <td >Celular:</td>
                <td colspan="6">{{$arreglo_observaciones[0]}}</td>
            </tr>
            <tr>
                <td >Correo:</td>
                <td colspan="6">{{$arreglo_observaciones[1]}}</td>
            </tr>
            <tr>
                <td colspan="7">&nbsp;</td>
            </tr>

        @endforeach
        
       
        
    </tbody>
</table>