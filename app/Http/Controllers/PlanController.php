<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use XAdmin\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //BD.spPlanAcccionIngresar(CInt(Request.QueryString("idMonitoreo")), CShort(cbSeveridad.SelectedItem.Value), txDetalle.Text, txObservaciones.Text)
        //DB::select('exec spPlanAcccionIngresar ?,?,?,?,?',array($monitor->idActivo,$monitor->FechaHoraInicio,$monitor->FechaHoraFin,$usuarioCreacion,$ip));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPlansMonitor($IdMonitor)
    {
        $planes['data']= DB::table('PlanAccionMonitoreo')->where('IdMonitoreo','=', $IdMonitor)->get();

        

        $response = array();
        
        return response()->json($planes);
    }
}
