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
use XAdmin\Http\Controllers\AlertController;

use Storage;

class AlertsExportAlertasPorMonitorista implements FromView, ShouldAutoSize, WithStyles, WithStrictNullComparison,  WithColumnWidths
{
    
    protected $fechaDesde;
    protected $fechaHasta;
    protected $agente;
    protected $grupo;

    

    

    public function __construct(Request $request)
    {
        $this->agente = $request->agente;
        $this->grupo = $request->grupo;
        $this->fechaDesde = $request->fechaDesde;
        $this->fechaHasta = $request->fechaHasta;
        


        if($this->fechaDesde == null)
            $this->fechaDesde = '';
        if($this->fechaHasta == null)
            $this->fechaHasta = '';
        if($this->agente == null)
            $this->agente = '';
        if($this->grupo == null )
            $this->grupo = '';
        

        
        
    }

    public function view(): View
    {
        //$monitors = DB::select('exec spAlertaSeguimientoConsultarxMonitoreo ?,?,?,?',array($this->idMonitoreo,$this->fechaDesde,$this->fechaHasta,1));
        //$infoAdicional = DB::select('exec spMonitoreoInfoAdicionalConsultar ?',array($this->idMonitoreo));//  IdMonitoreo


        //$puntos = $this->marcadores;
        $agente = $this->agente;
        $grupo = $this->grupo;
        $fechaDesde = $this->fechaDesde;
        $fechaHasta = $this->fechaHasta;
        

       

       

            if($agente=='')
            {
                $alertasAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                $alertasNoAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosNoAtendidosSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                $alertasGeneradas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosGeneradasSinNombre ?,?,?',array($fechaDesde,$fechaHasta,$grupo));
                $alertasAtendidasPorOtros = array();
            }else
            {
                $alertasAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasNoAtendidas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosNoAtendidosConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasGeneradas = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosGeneradasConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
                $alertasAtendidasPorOtros = DB::select('exec spAlertaSeguimientoConsultarLvAgrupadosAtendidosPorOtroConNombre ?,?,?,?',array($fechaDesde,$fechaHasta,$grupo,$agente));
            }

            //$response = $alertasAtendidasPorOtros;
            //return response()->json($response);
            

            $alertasAgrupadas = array();
            $sumaTiempos = array();

            $evento = '';

            /*********** ALERTAS GENERADAS *********/ 
            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
                    $alertasAgrupadas[$evento]['G'] = 0;
                
            }

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
                    $alertasAgrupadas[$evento]['G']++;
                
            }


            /************ ALERTAS ATENDIDAS ********/ 
            
            foreach($alertasAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
               
                    $alertasAgrupadas[$evento]['A'] = 0; 
                    $alertasAgrupadas[$evento]['TP'] = 0;
                    $sumaTiempos[$evento] = date('H:i:s',strtotime('00:00:00'));
                
            }
            //$response = $sumaTiempos;
            //return response()->json($response);


            foreach($alertasAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $diferenciaTiempos = date("H:i:s",strtotime($val->Diferencia));
                //return response()->json($diferenciaTiempos);
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
               
                    $alertasAgrupadas[$evento]['A']++;
                    $sumaTiempos[$evento] = app('XAdmin\Http\Controllers\AlertController')->sum_the_time($sumaTiempos[$evento],$diferenciaTiempos);
            
                
            }
            //$response = $sumaTiempos;     
            //return response()->json($response);
            

            foreach ($alertasAtendidas as $key => $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
            
                    $tiempoPromedioArreglo = explode(":",app('XAdmin\Http\Controllers\AlertController')->average_time($sumaTiempos[$evento],$alertasAgrupadas[$evento]['A']));
                    $alertasAgrupadas[$evento]['TP'] = $tiempoPromedioArreglo[1];//AlertController::average_time($sumaTiempos[$evento],$alertasAgrupadas[$evento]['A']);
                
            }

            //$response = $alertasAgrupadas;     
            //return response()->json($response);

            

            /********** ALERTAS NO ATENDIDAS **********/
            foreach($alertasNoAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
                    $alertasAgrupadas[$evento]['NA'] = 0;
                
            }

            foreach($alertasNoAtendidas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
               
                    $alertasAgrupadas[$evento]['NA']++;
                
            }

            /****** ALERTAS ATENDIDAS POR OTROS ******/

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
                    $alertasAgrupadas[$evento]['APO'] = 0;
                
            }

            foreach($alertasAtendidasPorOtros as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                
                    $alertasAgrupadas[$evento]['APO']++;
                
            }

            /************/

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                try {
                   
                        $alertasAgrupadas[$evento]['EFICIENCIA'] = number_format(($alertasAgrupadas[$evento]['A'] / $alertasAgrupadas[$evento]['G']) * 100)."%" ;
                } catch (\Throwable $th) {
                    $alertasAgrupadas[$evento]['EFICIENCIA'] = "0.00%";
                }
                
                
            }

            foreach($alertasGeneradas as $val) {
                $eventoTemp = $val->Alerta;
                $arregloEvento = explode(' - ',$eventoTemp);
                try {
                    $evento = $arregloEvento[1];
                } catch (\Throwable $th) {
                    $evento = $arregloEvento[0];
                }
                try {
                    
                        //$alertasAgrupadas[$evento]['EFICACIA'] = number_format(100-(($alertasAgrupadas[$evento]['TP'] * 100 / 10) - 100),2)."%" ;
                        if(number_format(100-(($alertasAgrupadas[$evento]['TP'] * 100 / 10) - 100),2)>=0)
                            $alertasAgrupadas[$evento]['EFICACIA'] = number_format(100-(($alertasAgrupadas[$evento]['TP'] * 100 / 10) - 100),2)."%" ;
                        else
                            $alertasAgrupadas[$evento]['EFICACIA'] = "0.00%";
                } catch (\Throwable $th) {
                    $alertasAgrupadas[$evento]['EFICACIA'] = "0.00%";
                }
                
                
            }
    
            
            
            
       

        if($agente=='')
            $agente="TODOS";
        if($grupo=='')
            $grupo="TODOS";
    

        

        return view('alerts.formatoAlertasPorMonitorista', [
            'agente' => $agente,
            'grupo' => $grupo,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'alertasAgrupadas' => $alertasAgrupadas
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A6:I6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A6:I6')->getFill()->getStartColor()->setARGB('e3e3e3');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'C' => 8,
            'D' => 8, 
            'E' => 8,
            'F' => 8,
            'G' => 8,
            'B' => 8, 
            'H' => 8,   
            'I' => 8,        
        ];
    }

}
