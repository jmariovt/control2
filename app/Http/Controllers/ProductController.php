<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        //
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

    public function getProductByAsset($IdActivo)
    {
        $tabla = 'PRODUCTOACTIVO';
        //$IdActivo = $request->IdActivo;
         
        $products['data'] = DB::select('exec spLlenarCombo ?,?',array($tabla,$IdActivo));

        $response = array();
        /*foreach($products as $product){
            $response[] = array("label"=>$product->Descripcion,"value"=>$product->Codigo);
        }*/
        return response()->json($products);
    }

    public function getProductByAssetInterno($IdActivo)
    {
        $tabla = 'PRODUCTOACTIVO';
        //$IdActivo = $request->IdActivo;
         
        $products = DB::select('exec spLlenarCombo ?,?',array($tabla,$IdActivo));

        $response = array();
        /*foreach($products as $product){
            $response[] = array("label"=>$product->Descripcion,"value"=>$product->Codigo);
        }*/
        return $products;
    }

    public function getEventProduct($IdProductoDispositivo)
    {
        $tabla = 'PRODUCTOEVENTOCONTROL';
        //$IdActivo = $request->IdActivo;
         
        $events['data'] = DB::select('exec spLlenarCombo ?,?',array($tabla,$IdProductoDispositivo));

        $response = array();
        /*foreach($products as $product){
            $response[] = array("label"=>$product->Descripcion,"value"=>$product->Codigo);
        }*/
        return response()->json($events);
    }

    public function getEventProductInterno($IdProductoDispositivo)
    {
        $tabla = 'PRODUCTOEVENTOCONTROL';
        //$IdActivo = $request->IdActivo;
         
        $events = DB::select('exec spLlenarCombo ?,?',array($tabla,$IdProductoDispositivo));

        $response = array();
        /*foreach($products as $product){
            $response[] = array("label"=>$product->Descripcion,"value"=>$product->Codigo);
        }*/
        return $events;
    }


    public function buscarNombreProducto(Request $request)
    {
       
        $buscar = $request->search;
        
        
        $productos = DB::table('Producto')->select('Nombre')->where('Nombre','LIKE','%'.$buscar.'%')->limit(100)->get();
        
        $response = array();
        
        foreach($productos as $producto){
            $response[] = array("label"=>$producto->Nombre);
         }
        
        return response()->json($response);
        //return $entidad;
    
    }
}
