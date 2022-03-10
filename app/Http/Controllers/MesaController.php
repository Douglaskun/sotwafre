<?php

namespace App\Http\Controllers;

use App\Mesa;
use App\Producto;
use Illuminate\Support\Facades\DB;
use App\Comensal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        return view("welcome");
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
        $productos = [];
        $count = count(array($request->get('mesas')));
        $mesa = new Mesa();
        for($a =0 ; $a < $count ; $a++ ) {
          foreach ($request->get('mesas') as $id => $value) {
            $productos[] =  Mesa::find($NunMesa)
                            ? $NunMesa
                            : Mesa::create($request->get('mesas')[$a])->NunMesa; 
                                  
          }

        } 
        $mesa = new Mesa();
          $mesa->NunMesa=19;
          $mesa->ocupado = 0;
   //     $apoyo->productos()->sync($productos);
       
        
      //  $mesa->NunMesa = 17;
        
        $mesa->save();
  
        return redirect('/home');
       //return "hola";
    }
    public function VerPedido($idMesa)
    {
        $vacio = 0;
        $id = 1;
        $tipoProducto = "";

        //obteniendo idPedido segun el id de la Mesa
        // $idPedido = DB::table('pedidos')->select('idPedido')->where('estPed', '=', 0)->where('idMesa', '=', $idMesa)->get();
        // if (count($idPedido)) {

        // select * from 

        $datos = DB::table('productos')
            ->join('detallepedido', 'productos.idProducto', '=', 'detallepedido.idProducto')
            ->join('pedidos', 'detallepedido.idPedido', '=', 'pedidos.idPedido')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('detallepedido.idDetallePedido', 'productos.nombreProducto', 'detallepedido.cantidad', 'detallepedido.preciounitario', 'detallepedido.montSubDetPed', 'pedidos.idPedido')
            ->where('mesas.idMesa', '=', $idMesa)
            ->where('pedidos.estPed', '=', 0)
            ->get();

        count($datos) ? $vacio = 1 : $vacio = 0;

        if ($vacio == 1) {
            $validarmozo = DB::table('pedidos')
                ->join('users', 'pedidos.idUsuario', '=', 'users.id')
                ->select('users.isadmin', 'users.name', 'users.id', 'pedidos.idPedido')
                ->where('pedidos.idMesa', '=', $idMesa)
                ->where('pedidos.estPed', '=', 0)
                ->get();
            if ($validarmozo[0]->id == Auth::user()->id || Auth::user()->isadmin  == 1) {
                // return response()->json([$validarmozo, Auth::user()]);
                $tipoProducto = DB::table('tipo_productos')->select('*')->get();
            } else {

                $tipoProducto = [];
            }
        } else {
            $tipoProducto = DB::table('tipo_productos')->select('*')->get();
        }



        return view('VerPedido')->with('id', $id)->with('idMesa', $idMesa)->with('datos', $datos)->with('vacio', $vacio)->with('tipo_productos', $tipoProducto);
        // } else {


        // $datos = DB::table('pedidos')
        //     ->select('*')
        //     ->where('estPed', '=', 0)
        //     ->get();

        // $tipoProducto = DB::table('tipo_productos')->select('*')->get();
        // return view('VerPedido')->with('id', $id)->with('idMesa', $idMesa)->with('datos', $datos)->with('vacio', $vacio)->with('tipo_productos', $tipoProducto);
        // }



        // return $idPedido;


        // $datos = DB::table('pedidos')
        //     ->join('productos', 'pedidos.idProducto', '=', 'productos.idProducto')
        //     ->select('pedidos.idPedido', 'productos.nombreProducto', 'productos.precio', 'pedidos.cantidad', 'pedidos.subTotal')
        //     ->where('pedidos.idMesa', '=', $idMesa)
        //     ->get();


        // $datos = DB::table('pedidos')
        //     ->select('*')
        //     ->where('estPed', '=', 0)
        //     ->get();

        // $tipoProducto = DB::table('tipo_productos')->select('*')->get();


        // if (count($datos) == 0) {
        //     $est =  Mesa::find($idMesa);
        //     $est->ocupado = 0;
        //     $est->save();
        // } elseif (count($datos) > 0) {
        //     $est =  Mesa::find($idMesa);
        //     $est->ocupado = 1;
        //     $est->save();
        //     $vacio = 1;
        // }

        // return view('VerPedido')->with('id', $id)->with('idMesa', $idMesa)->with('datos', $datos)->with('vacio', $vacio)->with('tipo_productos', $tipoProducto);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesa $mesa)
    {
        //
    }
}
