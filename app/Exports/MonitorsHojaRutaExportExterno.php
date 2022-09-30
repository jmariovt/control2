<?php

namespace XAdmin\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

use Storage;


class MonitorsHojaRutaExportExterno implements FromView, ShouldAutoSize, WithStyles, WithStrictNullComparison,  WithColumnWidths
{
    protected $usuario,
    $Numero_Contenedor,
    $Pies_Contenedor,
    $TipoCarga_Contenedor,
    $placa,
    $marca,
    $color,
    $chofer_nombre,
    $chofer_celular,
    $acompanante_nombre,
    $acompanante_celular,
    $ruta_a_seguir,
    $fecha_inicio,
    $ciudad_origen,
    $direccion_origen,
    $fecha_fin,
    $ciudad_destino,
    $direccion_destino,
    $contacto1,
    $parada1,
    $nombreSeveridad0,
    $celularSeveridad0,
    $correoSeveridad0,
    $nombreSeveridad1,
    $celularSeveridad1,
    $correoSeveridad1,
    $nombreSeveridad2,
    $celularSeveridad2,
    $correoSeveridad2;

    protected $CantidadContactos;
    protected $CantidadParadas;
    protected $CantidadPlanes;
    

    public function __construct($usuario,
    $Numero_Contenedor,
    $Pies_Contenedor,
    $TipoCarga_Contenedor,
    $placa,
    $marca,
    $color,
    $chofer_nombre,
    $chofer_celular,
    $acompanante_nombre,
    $acompanante_celular,
    $ruta_a_seguir,
    $fecha_inicio,
    $ciudad_origen,
    $direccion_origen,
    $fecha_fin,
    $ciudad_destino,
    $direccion_destino,
    $contacto1,
    $parada1,
    $nombreSeveridad0,
    $celularSeveridad0,
    $correoSeveridad0,
    $nombreSeveridad1,
    $celularSeveridad1,
    $correoSeveridad1,
    $nombreSeveridad2,
    $celularSeveridad2,
    $correoSeveridad2)
    {
        //$this->IdMonitoreo = $IdMonitoreo;
        //$this->Usuario = $Usuario;
        
        //$this->Cliente = $Cliente;

        $this->usuario = $usuario;
        $this->Numero_Contenedor = $Numero_Contenedor; 
        $this->Pies_Contenedor = $Pies_Contenedor;
        $this->TipoCarga_Contenedor = $TipoCarga_Contenedor;
        $this->placa = $placa;
        $this->marca = $marca;
        $this->color = $color;
        $this->chofer_nombre = $chofer_nombre; 
        $this->chofer_celular = $chofer_celular;
        $this->acompanante_nombre = $acompanante_nombre;
        $this->acompanante_celular = $acompanante_celular;
        $this->ruta_a_seguir = $ruta_a_seguir;
        $this->fecha_inicio = $fecha_inicio;
        $this->ciudad_origen = $ciudad_origen;
        $this->direccion_origen = $direccion_origen;
        $this->fecha_fin = $fecha_fin;
        $this->ciudad_destino = $ciudad_destino;
        $this->direccion_destino = $direccion_destino;
        $this->contacto1 = $contacto1;
        $this->parada1 = $parada1;
        $this->nombreSeveridad0 = $nombreSeveridad0;
        $this->celularSeveridad0 = $celularSeveridad0;
        $this->correoSeveridad0 = $correoSeveridad0;
        $this->nombreSeveridad1 = $nombreSeveridad1;
        $this->celularSeveridad1 = $celularSeveridad1;
        $this->correoSeveridad1 = $correoSeveridad1;
        $this->nombreSeveridad2 = $nombreSeveridad2;
        $this->celularSeveridad2 = $celularSeveridad2;
        $this->correoSeveridad2 = $correoSeveridad2;
        

      

    }

    public function view(): View
    {

        //$datosCliente = DB::select('exec spMonitoreoHojaRutaConsultar ?',array($this->IdMonitoreo));

        //$this->CantidadContactos = sizeof(explode('%',$datosCliente[0]->ContactosRecorrido));
        //$this->CantidadParadas = sizeof(explode('%',$datosCliente[0]->ParadasPermitidas));


        //$planesAccion = DB::select('exec spPlanAccionConsultarxMonitoreo ?',array($this->IdMonitoreo));
        //$this->CantidadPlanes = sizeof($planesAccion);





        //$this->registros = sizeof($monitors);
        

        return view('monitors.reporteHojaRuta', [
            //'datosCliente' => $datosCliente,
            //'planesAccion' => $planesAccion

            'usuario' => $this->usuario,
            'Numero_Contenedor' => $this->Numero_Contenedor,
            'Pies_Contenedor' => $this->Pies_Contenedor,
            'TipoCarga_Contenedor' => $this->TipoCarga_Contenedor,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'color' => $this->color,
            'chofer_nombre' => $this->chofer_nombre,
            'chofer_celular' => $this->chofer_celular,
            'acompanante_nombre' => $this->acompanante_nombre,
            'acompanante_celular' => $this->acompanante_celular,
            'ruta_a_seguir' => $this->ruta_a_seguir,
            'fecha_inicio' => $this->fecha_inicio,
            'ciudad_origen' => $this->ciudad_origen,
            'direccion_origen' => $this->direccion_origen,
            'fecha_fin' => $this->fecha_fin,
            'ciudad_destino' => $this->ciudad_destino,
            'direccion_destino' => $this->direccion_destino,
            'contacto1' => $this->contacto1,
            'parada1' => $this->parada1,
            'nombreSeveridad0' => $this->nombreSeveridad0,
            'celularSeveridad0' => $this->celularSeveridad0,
            'correoSeveridad0' => $this->correoSeveridad0,
            'nombreSeveridad1' => $this->nombreSeveridad1,
            'celularSeveridad1' => $this->celularSeveridad1,
            'correoSeveridad1' => $this->correoSeveridad1,
            'nombreSeveridad2' => $this->nombreSeveridad2,
            'celularSeveridad2' => $this->celularSeveridad2,
            'correoSeveridad2' => $this->correoSeveridad2
            
            
        ]);
    }

    

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A3:A32')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:A32')->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A17')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A17')->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A25')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A25')->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A33')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A33')->getFill()->getStartColor()->setARGB('C0C0C0');

        $fila = 34;
        for ($i=0; $i < $this->CantidadContactos ; $i++) { 
            $celda1 = $fila + 1;
            $celda2 = $fila + 2;
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->getStartColor()->setARGB('C0C0C0');

            $fila = $fila + 3;
        }

        $fila = $fila + 1;
        $sheet->getStyle('A'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A'.$fila)->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A'.$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $fila = $fila + 1;

        for ($i=0; $i < $this->CantidadParadas ; $i++) { 
            $celda1 = $fila + 1;
            $celda2 = $fila + 2;
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->getStartColor()->setARGB('C0C0C0');

            $fila = $fila + 3;
        }

        $fila = $fila + 1;
        $sheet->getStyle('A'.$fila)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A'.$fila)->getFill()->getStartColor()->setARGB('C0C0C0');
        $sheet->getStyle('A'.$fila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$fila)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $fila = $fila + 1;

        for ($i=0; $i < $this->CantidadPlanes ; $i++) { 
            $celda1 = $fila + 1;
            $celda2 = $fila + 3;
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A'.$celda1.':A'.$celda2)->getFill()->getStartColor()->setARGB('C0C0C0');

            $fila = $fila + 4;
        }

        // Ajustar el texto de las celdas
        $sheet->getStyle('A3:A'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('B3:B'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('C3:C'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('D3:D'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('E3:E'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('F3:F'.$fila)->getAlignment()->setWrapText(true);
        $sheet->getStyle('G3:G'.$fila)->getAlignment()->setWrapText(true);

        $sheet->getStyle('A3:A'.$fila)->getFont()->setBold(true);
        $sheet->getStyle('B7:B9')->getFont()->setBold(true);
        $sheet->getStyle('D7:D9')->getFont()->setBold(true);
        $sheet->getStyle('F7:F9')->getFont()->setBold(true);

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A17')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A17')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A25')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A25')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A33')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A33')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->getStyle('A1:G'.$fila)->getFont()->setSize(10);

        $sheet->getStyle('A1:G'.$fila)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:G'.$fila)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:G'.$fila)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:G'.$fila)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:G'.$fila)->applyFromArray($styleArray);

        //$sheet->getStyle('A1:G'.$fila)->getBorders()->getAll()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);


        /*$sheet->getStyle('A1')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1:G1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A2:G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A1:A2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('G1:G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->getStyle('A3:G11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A3:G11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A3:G11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A3:G11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


        $sheet->getStyle('A3:A11')->getFont()->setBold(true);
        $sheet->getStyle('A3:A11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:A11')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('D3:D11')->getFont()->setBold(true);
        $sheet->getStyle('D3:D11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('D3:D11')->getFill()->getStartColor()->setARGB('e3e3e3');
        
        $sheet->getStyle('13')->getFont()->setBold(true);

        $sheet->getStyle('A13:H13')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A13:H13')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A13:H13')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A13:H13')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->getStyle('A13:H13')->getFont()->setBold(true);
        $sheet->getStyle('A13:H13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A13:H13')->getFill()->getStartColor()->setARGB('e3e3e3');*/
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 13,
            'C' => 13,
            'D' => 13, 
            'E' => 13,
            'F' => 13,
            'G' => 13,            
        ];
    }
}
