<?php

namespace XAdmin\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

use Storage;


class MonitorsExport2 implements FromView, WithDrawings, WithStyles, WithStrictNullComparison, ShouldAutoSize, WithColumnWidths
{
    protected $idMonitoreo;
    protected $fechaDesde;
    protected $fechaHasta;
    protected $registros;
    protected $imprimeMapa;
    protected $cantidadDeMapas;

    

    public function __construct($idMonitoreo, $fechaDesde, $fechaHasta)
    {
        $this->idMonitoreo = $idMonitoreo;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;


        $monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,3));
        $this->registros = sizeof($monitors);


        $this->imprimeMapa = 1;

        $datosMarkers = DB::select('exec spMonitoreoRutaConsultar ?,?,?', array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta));


        $cantidadMarkers = sizeof($datosMarkers);



        $anadir2 = 0;
        $cantidadMapas = 1;

        if($cantidadMarkers > 35)
        {
            if(($cantidadMarkers % 35)>0)
                $anadir2 = 1;
            $cantidadMapas = (floor($cantidadMarkers / 35 )) + $anadir2;
        }

        $this->cantidadDeMapas = $cantidadMapas;
            

        $tope = 0;
        $contadorMarcadores = 0;

        for ($i=0; $i < $cantidadMapas; $i++) { 


            
            if($i == $cantidadMapas - 1)
            {   
                $tope = $cantidadMarkers - 1 ;
            }else
            {
                $tope = ($i * 35) + 34;
            }
            
            $latitudes = array();
            $longitudes = array();
            //$contadorMarcadores = 0;
            $markers = "";
            $markerOtros = "";
            $markerIni = "";

            $indiceMarcadoresTotales = 0;

            for ($indice=$i*35; $indice <= $tope; $indice++) { 
                $latitudes[$contadorMarcadores] = number_format($datosMarkers[$indice]->Latitud,30,".","");//str_replace(",",".",$datosMarkers[$indice]->Latitud);
                $longitudes[$contadorMarcadores] = number_format($datosMarkers[$indice]->Longitud,30,".",""); //str_replace(",",".",$datosMarkers[$indice]->Longitud);
                $markers = $markers . "|" . $latitudes[$indice] . "," . $longitudes[$indice];
                if($indice%35==0)
                    $markerIni = $markers;
                else
                    $markerOtros = $markerOtros . "|" . $latitudes[$indice] . "," . $longitudes[$indice];
                $contadorMarcadores = $contadorMarcadores + 1;
            }

            /*foreach($datosMarkers as $marcador)
            {

                $latitudes[$contadorMarcadores] = str_replace(",",".",$marcador->Latitud);
                $longitudes[$contadorMarcadores] = str_replace(",",".",$marcador->Longitud);
                $markers = $markers . "|" . $latitudes[$contadorMarcadores] . "," . $longitudes[$contadorMarcadores];
                if($contadorMarcadores==0)
                    $markerIni = $markers;
                else
                    $markerOtros = $markerOtros . "|" . $latitudes[$contadorMarcadores] . "," . $longitudes[$contadorMarcadores];
                $contadorMarcadores = $contadorMarcadores + 1;
            }*/


            $url = "https://maps.googleapis.com/maps/api/staticmap?size=400x400&maptype=roadmap\&markers=color:blue|label:I".$markerIni."&markers=size:mid|color:red".$markerOtros."&path=color:0x0000ff|weight:5|geodesic:true".$markers."&sensor=false&key=AIzaSyCWCTbxQub4945rIbP2HUawjN2adUwCelc";
            $this->urlM = $url;
        

            // try {
                $options = array(
                    "http"=>array(
                        "header"=>"User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
                    )
                );
                
                $context = stream_context_create($options);

                $cnt=0; 
                while($cnt < 4 && ($contents=@file_get_contents($url, false, $context))===FALSE) $cnt++;
                //$contents = file_get_contents($url, false, $context);
            //} catch (\Throwable $th) {
            //    $this->imprimeMapa = 0;
            //    $contents = "";
            // }
            

            $fdesde = str_replace("/","",$this->fechaDesde);
            $fhasta = str_replace("/","",$this->fechaHasta);


            $name = "mapa".$this->idMonitoreo.$fdesde.$fhasta.$i.".png";
            Storage::put("public/".$name, $contents);
            
        }
        
    }

    public function view(): View
    {
        $monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,3));
        $infoAdicional = DB::select('exec spMonitoreoInfoAdicionalConsultar ?',array($this->idMonitoreo));//  IdMonitoreo
        $listaVerificacionConsultar = DB::select('exec spMonitoreoListaVerificacionConsultar ?',array($this->idMonitoreo));
        
        //$this->registros = sizeof($monitors);
        
        $prueba = isset($listaVerificacionConsultar[0]) ? $listaVerificacionConsultar[0] : false;
        if ($prueba){
            $listaVerificacionConsultar = $prueba;
        }else{
            $listaVerificacionConsultar =  (object) array("Conductor"=>"",'Compania'=>'','Celular'=>'','LicenciaSi'=>'','LicenciaNo'=>'','ComentLicencia'=>'','CedulaSi'=>'','CedulaNo'=>'','ComentCedula'=>'','MatriculaSi'=>'',
            'MatriculaNo'=>'','ComentMatricula'=>'','SoatSi'=>'','SoatNo'=>'','ComentSoat'=>'','RevVehSi'=>'','RevVehNo'=>'','RevVehSi'=>'','ComentRevVeh'=>'','AlertasGSi'=>'','AlertasGNo'=>'','ComentPanVeh'=>'',
            'LParqueoSi'=>'','LParqueoNo'=>'','ComentLParqueo'=>'','LFrenoSi'=>'','LFrenoNo'=>'','ComentLFreno'=>'','LBajasSi'=>'','LBajasNo'=>'','ComentLBajas'=>'','LAltasSi'=>'','LAltasNo'=>'','ComentLAltas'=>'',
            'PitoSi'=>'','PitoNo'=>'','ComentPito'=>'','LlantasEstadoSi'=>'','LlantasEstadoNo'=>'','ComentLlantasEstado'=>'','LlantaEmerSi'=>'','LlantaEmerNo'=>'','ComentLlantaEmer'=>'','LimpParaSi'=>'','LimpParaNo'=>'','ComentLimpPara'=>'',
            'CinturonSi'=>'','CinturonNo'=>'','ComentCinturon'=>'','RetrovSi'=>'','RetrovNo'=>'','ComentRetrov'=>'','NumeroContenedor'=>'','Sellos'=>'','FrontalSi'=>'','FrontalNo'=>'','ComentFrontal'=>'',
            'DerechoSi'=>'','DerechoNo'=>'','ComentDerecho'=>'','IzquierdoSi'=>'','IzquierdoNo'=>'','ComentIzquierdo'=>'', 'CedulaNumero'=>'');
        }

        

        //$prueba = $listaVerificacionConsultars[0];

       
        return view('monitors.formato2', [
            'monitors' => $monitors, 
            'infoAdicional' => $infoAdicional[0],
            'listaVerificacionConsultar' => $listaVerificacionConsultar
        ]);
    }

    public function drawings()
    {
        $graficos = array();

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Hunter');
        $drawing->setPath(public_path('/Imagenes/logo_hunter_nuevo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('G6'); //G3

        array_push($graficos,$drawing);


        //$fila = 132 + $this->registros;
        //$celda = 'C'.$fila;

        $fdesde = str_replace("/","",$this->fechaDesde);
        $fhasta = str_replace("/","",$this->fechaHasta);

        if($this->imprimeMapa == 1)
        {
            $fila = 132 + $this->registros;
            for ($i=0; $i < $this->cantidadDeMapas; $i++) { 
                $drawingMapa = new Drawing();
                $drawingMapa->setName('Mapa');
                $drawingMapa->setDescription('Hunter');
                $drawingMapa->setPath(storage_path("app/public/mapa".$this->idMonitoreo.$fdesde.$fhasta.$i.".png"));
                $drawingMapa->setHeight(400);
                //$fila = 132 + $this->registros; // Para saber en qué fila ubicar el mapa
                $celda = 'D'.$fila;
                $drawingMapa->setCoordinates($celda); //L5
                $fila = $fila +22;
            }
            return $graficos;//[$drawing, $drawingMapa];
        }

        return [$drawing];
    }

    public function styles(Worksheet $sheet)
    {

       
        $sheet->getStyle('A1')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1:G1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A2:G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:A2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('G1:G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A3:G10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G10')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G10')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('A3:A10')->getFont()->setBold(true);
        $sheet->getStyle('A3:A10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:A10')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('D3:D10')->getFont()->setBold(true);
        $sheet->getStyle('D3:D10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('D3:D10')->getFill()->getStartColor()->setARGB('e3e3e3');
        
        $sheet->getStyle('13')->getFont()->setBold(true);

        /** CONDUCTOR */
        $sheet->getStyle('A12:G34')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A12:G34')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A12:G34')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A12:G34')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A12:A21')->getFont()->setBold(true);
        $sheet->getStyle('A12:A21')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A12:A21')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('B14:D14')->getFont()->setBold(true);
        $sheet->getStyle('B14:D14')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B14:D14')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('E21')->getFont()->setBold(true);
        $sheet->getStyle('E21')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('E21')->getFill()->getStartColor()->setARGB('e3e3e3');

        /** VEHICULO */
        $sheet->getStyle('A37:G56')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A37:G56')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A37:G56')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A37:G56')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A37:A43')->getFont()->setBold(true);
        $sheet->getStyle('A37:A43')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A37:A43')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('B38:D38')->getFont()->setBold(true);
        $sheet->getStyle('B38:D38')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('B38:D38')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('E43')->getFont()->setBold(true);
        $sheet->getStyle('E43')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('E43')->getFill()->getStartColor()->setARGB('e3e3e3');

        /** INSPECCIÓN DEL VEHÍCULO */
        $sheet->getStyle('A59')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A59')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A59:G81')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A59:G81')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A59:G81')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A59:G81')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A59:A81')->getFont()->setBold(true);
        $sheet->getStyle('A59:A81')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A59:A81')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('C61:E61')->getFont()->setBold(true);
        $sheet->getStyle('C61:E61')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('C61:E61')->getFill()->getStartColor()->setARGB('e3e3e3');

        /** INSPECCIÓN DEL CONTENEDOR */
        $sheet->getStyle('A91')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A91')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A91:G124')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A91:G124')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A91:G124')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A91:G124')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A91:A104')->getFont()->setBold(true);
        $sheet->getStyle('A91:A104')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A91:A104')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('C94:E94')->getFont()->setBold(true);
        $sheet->getStyle('C94:E94')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('C94:E94')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('F93')->getFont()->setBold(true);
        $sheet->getStyle('F93')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('F93')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('E104')->getFont()->setBold(true);
        $sheet->getStyle('E104')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('E104')->getFill()->getStartColor()->setARGB('e3e3e3');

        /**  REPORTE DE NOVEDADES */
        $sheet->getStyle('A128')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A128')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle('A128')->getFont()->setBold(true);
        $sheet->getStyle('A128')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A128')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('A130:G130')->getFont()->setBold(true);
        $sheet->getStyle('A130:G130')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A130:G130')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('A128:G130')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A128:G130')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A128:G130')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A128:G130')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('A3:F10')->applyFromArray($styleArray);
        $sheet->getStyle('A12:G34')->applyFromArray($styleArray);
        $sheet->getStyle('A37:G56')->applyFromArray($styleArray);
        $sheet->getStyle('A59:G81')->applyFromArray($styleArray);
        $sheet->getStyle('A91:G124')->applyFromArray($styleArray);



        $fila = 130 + $this->registros;
        $sheet->getStyle('A128:G'.$fila)->applyFromArray($styleArray);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToPage(FALSE);
        $sheet->getPageSetup()->setScale(62);

        // Ajustar el texto de las celdas
        $sheet->getStyle('A1:G'.$fila)->getAlignment()->setWrapText(true);
        
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'D' => 17, 
            'G' => 37,
            'B' => 10,            
        ];
    }
}

