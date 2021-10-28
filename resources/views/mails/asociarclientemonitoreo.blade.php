<html> 
    <head> 
        <title>Hunter Monitoreo - Acceso para Lista Verificación</title> 
    </head> 
    <body> 
                <h1>Estimado Cliente {{$terceroNombre}}</h1> 
                @if($tipoCliente=="I")
                    Podrá ingresar la Lista de Verificación para el Monitoreo con el Detalle: " {{$textoMonitoreo}} " del cliente: " {{$clienteNombre}} ", ingresando a la siguiente página: <a href='http://www.huntermonitoreo.com/xadmin/HRMonitoreo.aspx' target='blank'> Clic aquí </a><br><br>
                @else
                    Podrá asignar la unidad para la Hoja de Ruta y Lista de Verificación para el Monitoreo con el Detalle: " {{$textoMonitoreo}} " del cliente: " {{$clienteNombre}} ", ingresando a la siguiente página: <a href='http://www.huntermonitoreo.com/xadmin/HRMonitoreo.aspx' target='blank'> Clic aquí </a><br><br>
                @endif
                <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                    <tr> 
                        <th>Usuario: </th><td>{{$tercero}}</td> 
                    </tr> 
                    <tr style="background-color: #e0e0e0;"> 
                        <th>Contrase&ntilde;a: </th><td>{{$clave}}</td> 
                    </tr> 

                </table> 
                </br>
                </br>
                Gracias por preferirnos
            </body> 
            </html>