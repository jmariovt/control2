<?php

namespace XAdmin\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Storage;

class AlertsExportSeguimientoAlertas implements FromView, ShouldAutoSize, WithStyles, WithStrictNullComparison,  WithColumnWidths
{
    protected $unidadBuscar;
    protected $idActivo;
    protected $fechaDesde;
    protected $fechaHasta;
    protected $btSeguimientoAlertaBuscar;

    protected $totalAlertasGeneradas;
    protected $totalAlertasContestadas;
    protected $promedioAlertasContestadas;
    protected $tiempoRespuestaPromedio;
    protected $promRobos;
    protected $promCasosEnviados;
    protected $promRepetidas;
    protected $promDatosIncorrectos;
    protected $totalAlertasContestadasAgente;
    protected $promAlertasContestadasAgente;
    protected $promAlertasTotalContestadasAgente;

    public function __construct(Request $request)
    {
        $this->unidadBuscar = $request->unidadBuscar;
        $this->idActivo = $request->idActivo;
        $this->fechaDesde = $request->fechaDesde;
        $this->fechaHasta = $request->fechaHasta;
        $this->btSeguimientoAlertaBuscar = $request->btSeguimientoAlertaBuscar;

        $this->totalAlertasGeneradas = $request->totalAlertasGeneradas;
        $this->totalAlertasContestadas = $request->totalAlertasContestadas;
        $this->promedioAlertasContestadas = $request->promedioAlertasContestadas;
        $this->tiempoRespuestaPromedio = $request->tiempoRespuestaPromedio;
        $this->promRobos = $request->promRobos;
        $this->promCasosEnviados = $request->promCasosEnviados;
        $this->promRepetidas = $request->promRepetidas;
        $this->promDatosIncorrectos = $request->promDatosIncorrectos;
        $this->totalAlertasContestadasAgente = $request->totalAlertasContestadasAgente;
        $this->promAlertasContestadasAgente = $request->promAlertasContestadasAgente;
        $this->promAlertasTotalContestadasAgente = $request->promAlertasTotalContestadasAgente;

        
        
    }

    public function view(): View
    {
        //$monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,1));
        //$infoAdicional = DB::select('exec spMonitoreoInfoAdicionalConsultar ?',array($this->idMonitoreo));//  IdMonitoreo


        //$puntos = $this->marcadores;
        $totalAlertasGeneradas = $this->totalAlertasGeneradas;
        $totalAlertasContestadas = $this->totalAlertasContestadas;
        $promedioAlertasContestadas = $this->promedioAlertasContestadas;
        $tiempoRespuestaPromedio = $this->tiempoRespuestaPromedio;
        $promRobos = $this->promRobos;
        $promCasosEnviados = $this->promCasosEnviados;
        $promRepetidas = $this->promRepetidas;
        $promDatosIncorrectos = $this->promDatosIncorrectos;
        $totalAlertasContestadasAgente = $this->totalAlertasContestadasAgente;
        $promAlertasContestadasAgente = $this->promAlertasContestadasAgente;
        $promAlertasTotalContestadasAgente = $this->promAlertasTotalContestadasAgente;



        return view('alerts.formatoseguimientoalertas', [
            'totalAlertasGeneradas' => $totalAlertasGeneradas,
            'totalAlertasContestadas' => $totalAlertasContestadas,
            'promedioAlertasContestadas' => $promedioAlertasContestadas,
            'tiempoRespuestaPromedio' => $tiempoRespuestaPromedio,
            'promRobos' => $promRobos,
            'promCasosEnviados' => $promCasosEnviados,
            'promRepetidas' => $promRepetidas,
            'promDatosIncorrectos' => $promDatosIncorrectos,
            'totalAlertasContestadasAgente' => $totalAlertasContestadasAgente,
            'promAlertasContestadasAgente' => $promAlertasContestadasAgente,
            'promAlertasTotalContestadasAgente' => $promAlertasTotalContestadasAgente
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A10:N10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A10:N10')->getFill()->getStartColor()->setARGB('e3e3e3');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'C' => 8,
            'D' => 8, 
            'G' => 8,
            'B' => 8,            
        ];
    }

}
