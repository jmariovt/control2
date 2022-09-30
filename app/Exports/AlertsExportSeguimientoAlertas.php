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

    protected $tipoAlerta;
    protected $agente;
    protected $producto;
    protected $dispositivo;
    protected $motivoAlerta;
    protected $alertasRepetidas;
    protected $casosEnviados;
    protected $robos;
    protected $datosIncorrectos;

    

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


        $this->tipoAlerta = $request->tipoAlerta;
        $this->agente = $request->agente;
        $this->producto = $request->producto;
        $this->dispositivo = $request->dispositivo;
        $this->motivoAlerta = $request->motivoAlerta;
        $this->alertasRepetidas = $request->alertasRepetidas;
        $this->casosEnviados = $request->casosEnviados;
        $this->robos = $request->robos;
        $this->datosIncorrectos = $request->datosIncorrectos;


        if($this->fechaDesde == null)
            $this->fechaDesde = '';
        if($this->fechaHasta == null)
            $this->fechaHasta = '';
        if($this->tipoAlerta == null)
            $this->tipoAlerta = '0';
        if($this->unidadBuscar == null )
            $this->unidadBuscar = '';
        if($this->idActivo == null || $this->idActivo == '')
            $this->idActivo = '0';
        //if($this->agente == null)
        //    $this->agente = '';
        if($this->producto == null)
            $this->producto = '';
        if($this->dispositivo == null)
            $this->dispositivo = '';
        if($this->motivoAlerta == null)
            $this->motivoAlerta = '0';
        if($this->alertasRepetidas == null)
            $this->alertasRepetidas = '';
        if($this->casosEnviados == null)
            $this->casosEnviados = '';
        if($this->robos == null)
            $this->robos = '';
        if($this->datosIncorrectos == null)
            $this->datosIncorrectos = '';

        
        
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
        $fechaDesde = $this->fechaDesde;
        $fechaHasta = $this->fechaHasta;
        $idActivo = $this->idActivo;
        $agente = $this->agente;
        $producto = $this->producto;
        $dispositivo = $this->dispositivo;
        $tipoAlerta = $this->tipoAlerta;
        $motivoAlerta = $this->motivoAlerta;
        $alertasRepetidas = $this->alertasRepetidas;
        $casosEnviados = $this->casosEnviados;
        $robos = $this->robos;
        $datosIncorrectos = $this->datosIncorrectos;

        $idUsuario = session('idUsuario');
        $idSubUsuario = session('idSubUsuario');
        $idCategoria = session('idCategoria');

        if($fechaDesde == null)
            $fechaDesde = '';
        if($fechaHasta == null)
            $fechaHasta = '';
        if($tipoAlerta == null)
            $tipoAlerta = '0';
        if($idActivo == null || $idActivo == '')
            $idActivo = '0';
        if($agente == null)
            $agente = '';
        if($producto == null)
            $producto = '';
        if($dispositivo == null)
            $dispositivo = '';
        if($motivoAlerta == null)
            $motivoAlerta = '0';
        if($alertasRepetidas == null)
            $alertasRepetidas = '';
        if($casosEnviados == null)
            $casosEnviados = '';
        if($robos == null)
            $robos = '';
        if($datosIncorrectos == null)
            $datosIncorrectos = '';


       

        if($idSubUsuario=="0")
        {
            // ES UN USUARIO INTERNO
            $alertas = DB::select('exec spAlertaSeguimientoConsultarLv ?,?,?,?,?,?,?,?,?,?,?,?',array($idActivo,$fechaDesde,$fechaHasta,$agente,$producto,$dispositivo,$tipoAlerta,$motivoAlerta,$alertasRepetidas,$casosEnviados,$robos,$datosIncorrectos));    
            //$parametros = $this->idActivo.' - '.$this->fechaDesde.' - '.$this->fechaHasta.' - '.$this->agente.' - '.$this->producto.' - '.$this->dispositivo.' - '.$this->tipoAlerta.' - '.$this->motivoAlerta.' - '.$this->alertasRepetidas.' - '.$this->casosEnviados.' - '.$this->robos.' - '.$this->datosIncorrectos;
        }else
        {
            if($this->agente=='')
            {
                $alertas = DB::select('exec spAlertaSeguimientoConsultarLvExternoSinNombre ?,?,?,?,?,?,?,?,?,?,?,?',array($this->idActivo,$this->fechaDesde,$this->fechaHasta,$this->agente,$this->producto,$this->dispositivo,$this->tipoAlerta,$this->motivoAlerta,$this->alertasRepetidas,$this->casosEnviados,$this->robos,$this->datosIncorrectos));
                
            }else
            {
                $alertas = DB::select('exec spAlertaSeguimientoConsultarLvExterno ?,?,?,?,?,?,?,?,?,?,?,?',array($this->idActivo,$this->fechaDesde,$this->fechaHasta,$this->agente,$this->producto,$this->dispositivo,$this->tipoAlerta,$this->motivoAlerta,$this->alertasRepetidas,$this->casosEnviados,$this->robos,$this->datosIncorrectos));
                
            }
        }

        

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
            'promAlertasTotalContestadasAgente' => $promAlertasTotalContestadasAgente,
            'alertas'=>$alertas,
            'idSubUsuario'=>$idSubUsuario,
            'agente'=>$agente
            
            
            
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
