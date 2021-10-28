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

class MonitorsExportClienteMonitoreo implements FromView, WithDrawings, ShouldAutoSize, WithStyles, WithStrictNullComparison,  WithColumnWidths
{
    protected $UsuarioControl;
    protected $fechaDesde;
    protected $fechaHasta;
    protected $cantidadDeRegistros;

    public function __construct($UsuarioControl, $fechaDesde, $fechaHasta)
    {
        $this->UsuarioControl = $UsuarioControl;
        $this->fechaDesde = $fechaDesde;
        $this->fechaHasta = $fechaHasta;
        $novedades = DB::select('exec spAlertaSeguimientoConsultarNovedadesxUsuario ?,?,?',array($this->UsuarioControl,$this->fechaDesde,$this->fechaHasta));
        $this->cantidadDeRegistros = sizeof($novedades);
    }

    public function view(): View
    {
        $novedades = DB::select('exec spAlertaSeguimientoConsultarNovedadesxUsuario ?,?,?',array($this->UsuarioControl,$this->fechaDesde,$this->fechaHasta));
        
        
        

        return view('monitors.reporteNovedadesCliente', [
            'UsuarioControl' => $this->UsuarioControl, 
            'fechaDesde' => $this->fechaDesde,
            'fechaHasta' => $this->fechaHasta,
            'novedades' => $novedades
        ]);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Hunter');
        $drawing->setPath(public_path('/Imagenes/logo_hunter_nuevo.png'));
        //$drawing->setHeight(90);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }


    public function styles(Worksheet $sheet)
    {
        $ultimaFila = $this->cantidadDeRegistros + 13 ;

        $sheet->getStyle('A7')->getFont()->setBold(true);
        $sheet->getStyle('A7')->getFont()->setSize(15);

        

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A7:I7')->applyFromArray($styleArray);

        $sheet->getStyle('A9:B9')->applyFromArray($styleArray);
        $sheet->getStyle('A10:D10')->applyFromArray($styleArray);
        $sheet->getStyle('A13:I'.$ultimaFila)->applyFromArray($styleArray);

        $sheet->getStyle('A9')->getFont()->setBold(true);
        $sheet->getStyle('A10')->getFont()->setBold(true);
        $sheet->getStyle('C10')->getFont()->setBold(true);
        $sheet->getStyle('A13:I13')->getFont()->setBold(true);


        $sheet->getStyle('A9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A9')->getFill()->getStartColor()->setARGB('00308F');
        $sheet->getStyle('A9')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->getStyle('A13:I13')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A13:I13')->getFill()->getStartColor()->setARGB('00308F');
        $sheet->getStyle('A13:I13')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A13:I'.$ultimaFila)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Ajustar el texto de las celdas
        $sheet->getStyle('A13:I'.$ultimaFila)->getAlignment()->setWrapText(true);

       // $sheet->getStyle('A3:F11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
       //$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
       $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
       $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
       $sheet->getPageSetup()->setFitToPage(FALSE);
       $sheet->getPageSetup()->setScale(90);

       
    }
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15, 
            'D' => 15,
            'E' => 15,
            'F' => 30,
            'G' => 15,
            'H' => 15,
            'I' => 15,            
        ];
    }
}
