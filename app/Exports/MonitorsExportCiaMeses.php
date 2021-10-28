<?php

namespace XAdmin\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

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
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class MonitorsExportCiaMeses implements FromView, WithStyles, ShouldAutoSize
{
    protected $meses;
    protected $cia;
    
    use Exportable;


    public function __construct($meses, $cia)
    {
        $this->meses = $meses;
        $this->cia = $cia;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        

                    $monitors = DB::table('Monitoreo')
                    ->select('UsuarioCreacion',
                        DB::raw("COUNT(*) as TOTAL"))
                    ->groupBy('UsuarioCreacion')
                    ->get();
        return $monitors;
    }*/

    public function view(): View
    {
        $monitors = DB::table('Monitoreo')
                    ->select('UsuarioCreacion',
                        DB::raw("COUNT(*) as TOTAL"))
                    ->groupBy('UsuarioCreacion')
                    ->get();
        return view('monitors.ciameses', 
            ['monitors' => $monitors]
        );
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true)->setUnderline(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1:G3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A1:G3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A1:G3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A1:G3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->getStyle('A1:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:G3')->getFill()->getStartColor()->setARGB('e3e3e3');

        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
