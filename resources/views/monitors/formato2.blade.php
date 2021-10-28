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
            <td colspan="2">{{$infoAdicional->Compania}}</td>
            <td>FECHA INFORME</td>
            <td colspan="2">{{$infoAdicional->FechaInforme}}</td>
            
        </tr>
        <tr>
            <td>VEHÍCULO</td>
            <td colspan="2">{{$infoAdicional->Vehiculo}}</td>
            <td>VID VEHÍCULO</td>
            <td colspan="2">{{$infoAdicional->VID}}</td>
        </tr>
        <tr>
            <td>PLACA</td>
            <td colspan="2">{{$infoAdicional->Placa}}</td>
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
            <td colspan="2">{{$infoAdicional->LugarSalida}}</td>
            <td>FECHA FIN DE MONITOREO</td>
            <td colspan="2">{{$infoAdicional->FechaFinMonitoreo}}</td>
        </tr>
        <tr>
            <td>LUGAR DE LLEGADA</td>
            <td colspan="2">{{$infoAdicional->LugarLlegada}}</td>
            <td>FECHA FIN DE MONITOREO</td>
            <td colspan="2">{{$infoAdicional->HoraFinMonitoreo}}</td>
        </tr>
        <tr>
            <td>CHOFER</td>
            <td colspan="2">{{$infoAdicional->Chofer}}</td>
            <td>CELULAR</td>
            <td colspan="2">{{$infoAdicional->ChoferCelular}}</td>
        </tr>
        <tr>
            <td>OFICIAL/OTROS</td>
            <td colspan="2">{{$infoAdicional->Oficial}}</td>
            <td>CELULAR</td>
            <td colspan="2">{{$infoAdicional->OficialCelular}}</td>
        </tr>
        <tr>
            <td colspan="7">&nbsp;</td>
        </tr>

        
        <tr>
            <td>CONDUCTOR</td>
            <td colspan="6">{{$listaVerificacionConsultar->Conductor}}</td>
        </tr>
        <tr>
            <td colspan="2">COMPAÑÍA DONDE LABORA</td>
            <td colspan="3">{{$listaVerificacionConsultar->Compania}}</td>
            <td>TELEFONO</td>
            <td>{{$listaVerificacionConsultar->Celular}}</td>
        </tr>
        <tr>
            <td>DOCUMENTACION</td>
            <td>CUMPLE</td>
            <td>NO CUMPLE</td>
            <td colspan="4">OBSERVACIÓN</td>
        </tr>
        <tr>
            <td rowspan="2">LICENCIA DE CONDUCIR VIGENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LicenciaSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LicenciaNo}}</td>
            <td colspan="4" rowspan="2">{{$listaVerificacionConsultar->ComentLicencia}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">CEDULA DE IDENTIDAD</td>
            <td rowspan="2">{{$listaVerificacionConsultar->CedulaSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->CedulaNo}}</td>
            <td rowspan="2" colspan="4">{{$listaVerificacionConsultar->ComentCedula}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2" colspan="2">NÚMERO DE CÉDULA DE IDENTIDAD</td>
            <td rowspan="2" colspan="5">{{$listaVerificacionConsultar->CedulaNumero}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="4">FOTO DE CÉDULA DE IDENTIDAD</td>
            <td colspan="3">FOTO DE LICENCIA DE CONDUCIR</td>
        </tr>
        <tr  >
            <td colspan="4" rowspan="13">&nbsp;</td>
            <td colspan="3" rowspan="13">&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>

        <tr>
            <td>VEHICULO</td>
            <td colspan="6">{{$infoAdicional->Vehiculo}}</td>
        </tr>
        <tr>
            <td>DOCUMENTACION</td>
            <td>CUMPLE</td>
            <td>NO CUMPLE</td>
            <td colspan="4">OBSERVACIÓN</td>
        </tr>
        <tr>
            <td rowspan="2">MATRICULA VIGENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->MatriculaSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->MatriculaNo}}</td>
            <td colspan="4" rowspan="2">{{$listaVerificacionConsultar->ComentMatricula}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td rowspan="2">SOAT VIGENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->SoatSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->SoatNo}}</td>
            <td colspan="4" rowspan="2">{{$listaVerificacionConsultar->ComentSoat}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="4">FOTO DE MATRICULA</td>
            <td colspan="3">FOTO DE SOAT</td>
        </tr>
        <tr>
            <td colspan="4" rowspan="13">&nbsp;</td>
            <td colspan="3" rowspan="13">&nbsp;</td>
        </tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>

        <tr><td colspan="7" rowspan="2">INSPECCIÓN DEL VEHÍCULO</td></tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>CUMPLE</td>
            <td>NO CUMPLE</td>
            <td colspan="3">OBSERVACIÓN</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2">LUCES DE PARQUEO EN BUEN ESTADO</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LParqueoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LParqueoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLParqueo}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LUCES DE FRENO EN BUEN ESTADO</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LFrenoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LFrenoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLFreno}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LUCES BAJAS FUNCIONAN CORRECTAMENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LBajasSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LBajasNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLBajas}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LUCES ALTAS FUNCIONAN CORRECTAMENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LAltasSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LAltasNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLAltas}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">PITO FUNCIONA CORRECTAMENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->PitoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->PitoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentPito}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LLANTAS EN BUEN ESTADO</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LlantasEstadoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LlantasEstadoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLlantasEstado}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LLANTA DE EMERGENCIA</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LlantaEmerSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LlantaEmerNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLlantaEmer}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">LIMPIA PARABRISAS FUNCIONAN CORRECTAMENTE</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LimpParaSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->LimpParaNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentLimpPara}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">CINTURÓN DE SEGURIDAD</td>
            <td rowspan="2">{{$listaVerificacionConsultar->CinturonSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->CinturonNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentCinturon}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">RETROVISORES</td>
            <td rowspan="2">{{$listaVerificacionConsultar->RetrovSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->RetrovNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentRetrov}}</td>
        </tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>

        <tr><td colspan="7" rowspan="2">INSPECCIÓN DEL CONTENEDOR</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2">NUMERO DEL CONTENEDOR</td>
            <td colspan="3">{{$listaVerificacionConsultar->NumeroContenedor}}</td>
            <td>SELLOS</td>
            <td>{{$listaVerificacionConsultar->Sellos}}</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2">PARTES DEL CONTENEDOR</td>
            <td rowspan="2">BUEN ESTADO</td>
            <td rowspan="2">MAL ESTADO</td>
            <td colspan="3" rowspan="2">OBSERVACIÓN</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">FRONTAL</td>
            <td rowspan="2">{{$listaVerificacionConsultar->FrontalSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->FrontalNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentFrontal}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">PARTE LATERAL IZQUIERDA</td>
            <td rowspan="2">{{$listaVerificacionConsultar->IzquierdoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->IzquierdoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentIzquierdo}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">PARTE LATERAL DERECHA</td>
            <td rowspan="2">{{$listaVerificacionConsultar->DerechoSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->DerechoNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentDerecho}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" rowspan="2">PANEL DE CONTROL</td>
            <td rowspan="2">{{$listaVerificacionConsultar->AlertasGSi}}</td>
            <td rowspan="2">{{$listaVerificacionConsultar->AlertasGNo}}</td>
            <td colspan="3" rowspan="2">{{$listaVerificacionConsultar->ComentPanVeh}}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="4">FOTO PARTE FRONTAL</td>
            <td colspan="3">FOTO DEL CANDADO</td>
        </tr>
        <tr>
            <td colspan="4" rowspan="20">&nbsp;</td>
            <td colspan="3" rowspan="20">&nbsp;</td>
        </tr>
       
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td colspan="7" rowspan="2"> REPORTE DE NOVEDADES </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        
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
            <td>{{$monitor->Lugar}}</td>
            <td>{{$monitor->Detenido}}</td>
            <td>{{$monitor->Llamada}}</td>
            <?php 
                if($monitor->Temperatura==0)
                    $temperatura = "N/A";
                else 
                    $temperatura = $monitor->Temperatura; 
                
            ?>
            <td>{{$temperatura}}</td>
            <td>{{$monitor->Novedad}}</td>
            <!--<td>{{$monitor->Kilometraje}}</td>-->
        </tr>
        @endforeach
    </tbody>
</table>