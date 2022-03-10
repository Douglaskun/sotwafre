<?php

namespace App\Http\Controllers;

use App\Consumo;
use App\Pedido;
use App\Mesa;
// use App\Boleta;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Redirect;

class ConsumoController extends Controller
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
    }

    public function creaBoleta($idPedido, $idComensal)
    {
        //actualizamos estPed =1 
        $pedido = Pedido::find($idPedido);
        $pedido->estPed = 1;
        $pedido->save();

        //actualizamos la Mesa = 0
        $mesa = Mesa::find($pedido->idMesa);
        $mesa->ocupado = 0;
        $mesa->save();


        //llenamos la tabla consumo o boleta con el id del comensal 
        $consumo = new Consumo();
        $consumo->idPedido = $pedido->idPedido;
        $consumo->idComensal =  $idComensal;
        $consumo->total = $pedido->subTotal;
        $consumo->save();

        $mesa = Mesa::all();
        //return view('principal', ['mesa' => $mesa]);
        // \Debugbar::info($mesa);
        $datos = DB::table('mesas')
            ->join('pedidos', 'mesas.idMesa', '=', 'pedidos.idMesa')
            ->join('users', 'pedidos.idUsuario', '=', 'users.id')
            ->select('mesas.idMesa', 'mesas.NumMesa', 'mesas.ocupado', 'pedidos.subTotal', 'users.name')
            ->where('estPed', '=', 0)
            ->get();
        return view('principal', ['mesa' => $mesa])->with('dat', $datos);
    }
    public function create($idMesa, $comensal = [])
    {

        $datos = DB::table('productos')
            ->join('detallepedido', 'productos.idProducto', '=', 'detallepedido.idProducto')
            ->join('pedidos', 'detallepedido.idPedido', '=', 'pedidos.idPedido')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('detallepedido.idDetallePedido', 'productos.nombreProducto', 'detallepedido.cantidad', 'detallepedido.preciounitario', 'detallepedido.montSubDetPed', 'pedidos.idPedido')
            ->where('mesas.idMesa', '=', $idMesa)
            ->where('pedidos.estPed', '=', 0)
            ->get();



        $pedido = DB::table('pedidos')->select('*')->where('estPed', '=', 0)->where('idMesa', '=', $idMesa)->get();

        // $consumo = new Consumo();
        // $consumo->idPedido = $pedido->idPedido;
        // $consumo->idComensal
        // return $comensal;
        return view('/boleta')->with('pedido', $pedido)->with('detallepedido', $datos)->with('idMesa', $idMesa)->with('comensal', $comensal);
        // $pedi = DB::table('pedidos')
        //     ->join('productos', 'pedidos.idProducto', '=', 'productos.idProducto')
        //     ->select('pedidos.idPedido', 'productos.nombreProducto', 'productos.precio', 'pedidos.cantidad', 'pedidos.subTotal')
        //     ->where('pedidos.idMesa', '=', $idMesa)
        //     ->get();

        // foreach ($datos as $aea) {
        //    echo $aea->idPedido;
        //     echo '  ';
        //      echo $aea->nombreProducto;
        //      echo '  ';
        //      echo $aea->precio;
        //      echo '  ';
        //      echo $aea->cantidad;
        //      echo '  ';
        //      echo $aea->subTotal;
        //       echo '<br>';

        //   $datos = new Consumo();
        //   $datos->nombreProducto = $request->input('NombreProducto');
        //   $datos->precio = $request->input('PrecioProducto');
        //   $datos->idTipoProducto =  $request->input('cbocomida');
        //   $datos->save();
        //     }
        // return view('CobrarMesa')->with('pedi', $pedi)->with('id', $id)->with('idMesa', $idMesa);
    }
    public function VerReporte()
    {
        return view('Reportes');
    }
    public function buscarComensal(Request $request, $idMesa)
    {
        $datos = DB::table('productos')
            ->join('detallepedido', 'productos.idProducto', '=', 'detallepedido.idProducto')
            ->join('pedidos', 'detallepedido.idPedido', '=', 'pedidos.idPedido')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('detallepedido.idDetallePedido', 'productos.nombreProducto', 'detallepedido.cantidad', 'detallepedido.preciounitario', 'detallepedido.montSubDetPed', 'pedidos.idPedido')
            ->where('mesas.idMesa', '=', $idMesa)
            ->where('pedidos.estPed', '=', 0)
            ->get();


        $pedido = DB::table('pedidos')->select('*')->where('estPed', '=', 0)->where('idMesa', '=', $idMesa)->get();

        $comensal = DB::table('comensal')->select('*')->where('dniCome', '=', $request->DniComensal)->get();
        if (count($comensal) > 0) {
            return view('/boleta')->with('pedido', $pedido)->with('detallepedido', $datos)->with('idMesa', $idMesa)->with('comensal', $comensal);
        } else {
            return view('/boleta')->with('pedido', $pedido)->with('detallepedido', $datos)->with('idMesa', $idMesa)->with('comensal', $comensal)->with('message', ' No se encontró al comenzal, puedes registrarlo ');
        }
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
     * @param  \App\Consumo  $consumo
     * @return \Illuminate\Http\Response
     */
    public function show($idMesa)
    {
        // $totalMesa = 0;
        // $may = -99999999;
        // $datos = new Boleta();
        // $datos->save();
        // $toditos = Boleta::all();
        // foreach ($toditos as $ae) {
        //     if ($ae->idBoleta > $may) {
        //         $may = $ae->idBoleta;
        //     }
        // }

        // $pedi = DB::table('pedidos')
        //     ->join('productos', 'pedidos.idProducto', '=', 'productos.idProducto')
        //     ->select('pedidos.idPedido', 'productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'pedidos.cantidad', 'pedidos.subTotal')
        //     ->where('pedidos.idMesa', '=', $idMesa)
        //     ->get();

        // foreach ($pedi as $val) {
        //     $consum = new Consumo();
        //     $consum->idProducto = $val->idProducto;
        //     $consum->idBoleta = $may;
        //     $consum->cantidad = $val->cantidad;
        //     $consum->total =   $val->subTotal;
        //     $consum->save();
        //     $totalMesa = $totalMesa + $val->subTotal;
        // }
        // $bol =  Boleta::find($may);
        // $bol->total =  $totalMesa;
        // // $bol->idMesa = $idMesa;
        // $bol->save();
        // DB::table('pedidos')->where('idMesa', '=', $idMesa)->delete();
        // return redirect('/AtenderMesa/' . $idMesa);
    }
    public function ReporteDia(Request $request)
    {
        $fecha = $request->input('FechaConsultar');
        // return $fecha;
        $users = DB::table('consumos')
            ->join('comensal', 'consumos.idComensal', '=', 'comensal.idComensal')
            ->join('pedidos', 'consumos.idPedido', '=', 'pedidos.idPedido')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('consumos.idConsumo', 'consumos.total', 'comensal.dniCome', 'comensal.nomCome', 'comensal.apeCome', 'mesas.NumMesa')
            ->selectRaw('TIME(consumos.created_at) as hora')
            ->whereDate('consumos.created_at', $fecha)
            ->get();



        return view('ReporteDetallado')->with('reporte', $users)->with('fecha', $fecha);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consumo  $consumo
     * @return \Illuminate\Http\Response
     */
    public function ReporteDetallado($id)
    { //idConsumo = $id



        $pedido = DB::table('consumos')
            ->join('pedidos', 'consumos.idPedido', '=', 'pedidos.idPedido')
            ->join('users', 'pedidos.idUsuario', '=', 'users.id')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('pedidos.idPedido', 'consumos.idConsumo', 'mesas.NumMesa', 'users.name', 'consumos.total', 'consumos.created_at')
            ->selectRaw('TIME(consumos.created_at) as hora')
            ->where('consumos.idConsumo', '=', $id)
            ->get();
        // echo $pedido;

        $detalleventa  = DB::table('detallepedido')
            ->join('productos', 'detallepedido.idProducto', '=', 'productos.idProducto')
            ->select('productos.nombreProducto', 'detallepedido.preciounitario', 'detallepedido.cantidad', 'detallepedido.montSubDetPed')
            ->where('detallepedido.idPedido', '=', $pedido[0]->idPedido)
            ->get();
        return view('ReporteMesa')->with('pedido', $pedido)->with('detallepedido', $detalleventa);

        //  $pdf = App::make('dompdf.wrapper');
        //  $pdf->loadHtml('<h1>hola</h1>');
        //  $pdf->loadView('Pdf', $mesa);
        //return $pdf->stream();
        //  return $pdf->stream();


        //$pdf = PDF::loadView('Pdf', compact('mesa'), compact('todos'));

        //return $pdf->stream();

        // return view('ReporteMesa')->with('id', $id)->with('pedidos', $todos)->with('mesa', $mesa)->with('id', $id);
    }
    public function ObtenerPdfDiario($fecha)
    {
        $total = 0;
        $newfecha = date("Y-m-d", strtotime($fecha));

        $mesa = DB::table('boletas')
            ->select('total', 'idMesa')
            ->selectRaw('TIME(created_at) as hora')
            ->whereDate('created_at', $newfecha)
            ->get();
        //$pdf = PDF::loadView('Pdf', compact('mesa'), compact('todos'));



        foreach ($mesa as $m) {
            $total = $total  + $m->total;
        }
        //   return $mesa;
        $pdf = PDF::loadView('ReporteDia', compact('mesa'), compact('fecha'));
        return $pdf->stream('fecha:' . $fecha . '_total:' . $total);
        //return $pdf->stream();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consumo  $consumo
     * @return \Illuminate\Http\Response
     */
    public function ObtenerPdf($id)
    {
        $pedido = DB::table('consumos')
            ->join('pedidos', 'consumos.idPedido', '=', 'pedidos.idPedido')
            ->join('users', 'pedidos.idUsuario', '=', 'users.id')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('pedidos.idPedido', 'consumos.idConsumo', 'mesas.NumMesa', 'users.name', 'consumos.total', 'consumos.created_at')
            ->selectRaw('TIME(consumos.created_at) as hora')
            ->where('consumos.idConsumo', '=', $id)
            ->get();

        $detalleventa  = DB::table('detallepedido')
            ->join('productos', 'detallepedido.idProducto', '=', 'productos.idProducto')
            ->select('productos.nombreProducto', 'detallepedido.preciounitario', 'detallepedido.cantidad', 'detallepedido.montSubDetPed')
            ->where('detallepedido.idPedido', '=', $pedido[0]->idPedido)
            ->get();

        // return response()->json([$pedido, $detalleventa]);

        //  $pdf = App::make('dompdf.wrapper');
        //  $pdf->loadHtml('<h1>hola</h1>');
        //  $pdf->loadView('Pdf', $mesa);
        //return $pdf->stream();
        //  return $pdf->stream();

        // return view('Pdf')->with('pedido', $pedido)->with('detalleventa', $detalleventa);
        $pdf = PDF::loadView('Pdf', compact('pedido'), compact('detalleventa'))->setPaper('a5');
        return $pdf->download('fecha:' . $pedido[0]->created_at . '_mesa:' . $pedido[0]->NumMesa . '.pdf');
        // foreach ($mesa as $v) {
        //     $newfecha = date("d-m-Y", strtotime($v->fecha));
        //     return $pdf->stream('fecha:' . $newfecha . '_mesa:' . $v->idMesa . '_hora:' . $v->hora . '.pdf');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consumo  $consumo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consumo $consumo)
    {
        //
    }
}
