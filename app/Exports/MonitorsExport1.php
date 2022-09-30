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


class MonitorsExport1 implements FromView, WithDrawings, ShouldAutoSize, WithStyles, WithStrictNullComparison,  WithColumnWidths
{
    protected $idMonitoreo;
    protected $fechaDesde;
    protected $fechaHasta;
    protected $registros;
    protected $imprimeMapa;
    protected $cantidadDeMapas;
    protected $marcadores;

    public function __construct($idMonitoreo, $fechaDesde, $fechaHasta)
    {
        $this->idMonitoreo = $idMonitoreo;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;


        $monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,1));
        $contador = 0;
        foreach ($monitors as $key => $monitor) {
            $novedadArray = explode("\\",$monitor->Novedad);
            $novedad = $novedadArray[0];
            if(strpos(strtoupper($novedad),'ALERTA REPETIDA')===false)
            {
                $contador++;
            }
        }

        $this->registros = $contador;//sizeof($monitors);

        $this->imprimeMapa = 1;

        $datosMarkers = DB::select('exec spMonitoreoRutaConsultar ?,?,?', array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta));

        $cantidadMarkers = sizeof($datosMarkers);
        $this->marcadores = $cantidadMarkers;

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
                //try {
                    $latitudes[$contadorMarcadores] = number_format($datosMarkers[$indice]->Latitud,30,".","");//str_replace(",",".",$datosMarkers[$indice]->Latitud);
                    $longitudes[$contadorMarcadores] = number_format($datosMarkers[$indice]->Longitud,30,".",""); //str_replace(",",".",$datosMarkers[$indice]->Longitud);
                    $markers = $markers . "|" . $latitudes[$indice] . "," . $longitudes[$indice];
                    if($indice%35==0)
                        $markerIni = $markers;
                    else
                        $markerOtros = $markerOtros . "|" . $latitudes[$indice] . "," . $longitudes[$indice];
                    $contadorMarcadores = $contadorMarcadores + 1;
                //} catch (\Throwable $th) {
                //    $contadorMarcadores = $contadorMarcadores + 1;
                //}
                
                
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
            //$this->urlM = $url;
        

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
        $monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,1));
        $infoAdicional = DB::select('exec spMonitoreoInfoAdicionalConsultar ?',array($this->idMonitoreo));//  IdMonitoreo

        //$this->registros = sizeof($monitors);
        
        //$url = $this->urlM;
        $puntos = $this->marcadores;

        return view('monitors.formato1', [
            'monitors' => $monitors, 
            'infoAdicional' => $infoAdicional[0],
            'puntos' => $puntos
            
        ]);
    }

    public function drawings()
    {
        $graficos = array();

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Hunter');
        $drawing->setPath(public_path('/Imagenes/logo_hunter_nuevo.png'));
        //$drawing->setHeight(45);
        //$drawing->setWidth(90);
        $drawing->setCoordinates('G6');

        array_push($graficos,$drawing);

        $fdesde = str_replace("/","",$this->fechaDesde);
        $fhasta = str_replace("/","",$this->fechaHasta);

        if($this->imprimeMapa == 1)
        {
            $fila = 16 + $this->registros;
            for ($i=0; $i < $this->cantidadDeMapas; $i++) { 
                $drawingMapa = new Drawing();
                $drawingMapa->setName('Mapa');
                $drawingMapa->setDescription('Hunter');
                $drawingMapa->setPath(storage_path("app/public/mapa".$this->idMonitoreo.$fdesde.$fhasta.$i.".png"));
                $drawingMapa->setHeight(400);
                //$fila = 16 + $this->registros; // Para saber en qué fila ubicar el mapa
                $celda = 'C'.$fila;
                $drawingMapa->setCoordinates($celda); //L5
                array_push($graficos,$drawingMapa);
                $fila = $fila +22;
            }
            

            return $graficos;
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

        $sheet->getStyle('A3:G11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A3:G11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A3:F11')->applyFromArray($styleArray);

        // Ajustar el texto de las celdas
        $sheet->getStyle('A3:F11')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A3:F11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:F11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('E3E3E3');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('A3:A11')->getFont()->setBold(true);
        $sheet->getStyle('A3:A11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:A11')->getFill()->getStartColor()->setARGB('E3E3E3');

        $sheet->getStyle('D3:D11')->getFont()->setBold(true);
        $sheet->getStyle('D3:D11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('D3:D11')->getFill()->getStartColor()->setARGB('E3E3E3');
        
        $sheet->getStyle('13')->getFont()->setBold(true);

        $sheet->getStyle('A13:G13')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A13:G13')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A13:G13')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A13:G13')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $fila = 14 + $this->registros;
        
        $sheet->getStyle('A13:G'.$fila)->applyFromArray($styleArray);

        // Ajustar el texto de las celdas
        $sheet->getStyle('A14:G'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A14:G'.$fila)->getFont()->setSize(8);

        $sheet->getStyle('A13:G13')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A13:G13')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A14:B'.$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A14:B'.$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D14:F'.$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D14:F'.$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C14:C'.$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('G14:G'.$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //$sheet->getStyle('A13:G13')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('A13:G13')->getFont()->setBold(true);
        $sheet->getStyle('A13:G13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A13:G13')->getFill()->getStartColor()->setARGB('e3e3e3');

       //$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
       $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
       $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
       $sheet->getPageSetup()->setFitToPage(FALSE);
       $sheet->getPageSetup()->setScale(60);//62

       $filaRepetir = array();
       $filaRepetir[0]='A13';
       $filaRepetir[1]='G13';

       $sheet->getPageSetup()->setRowsToRepeatAtTop($filaRepetir);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'C' => 37,
            'D' => 17, 
            'G' => 37,
            'B' => 10,            
        ];
    }
}
