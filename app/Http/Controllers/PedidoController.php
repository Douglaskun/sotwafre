<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;
use App\Mesa;
use App\DetallePedido;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class PedidoController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $idMesa, Request $request)
    {
        request()->validate([
            'cantidad' => 'Integer|required|numeric|min:1|not_in:0'
        ], [
            'cantidad.Integer' => 'La cantidad debe ser enter',
            'cantidad.required' => 'La cantidad no puede ir vacia',
            'cantidad.numeric' => 'El tipo debe ser numerico',
            'cantidad.min' => 'La cantidad mínimo debe ser 1',
            'cantidad.not_in' => 'La cantidad debe ser positiva'
        ]);

        //estPed : 0 -> no paga aun
        //estPed : 1 -> ya pagó
        $estPed = DB::table('pedidos')->select('*')->where('estPed', '=', '0')->get();

        // return $request->all();

        //comprobando si es que hay pedidos en la mesa
        if (!count(DB::table('pedidos')->select('*')->where('idMesa', '=', $idMesa)->where('estPed', '=', '0')->get())) {
            //vamos a crear la mesa con dicho idMesa
            $user = Auth::user();
            $pedido = new Pedido();
            $pedido->idMesa = $idMesa;
            $pedido->estPed = false;
            $pedido->subTotal = 0;
            $pedido->idUsuario = $user->id;
            $pedido->save();

            $this->llenardetallepedido($request->input('idProducto'), $pedido->idPedido, $request->input('cantidad'), $request->input('SubTotalProducto'), $idMesa, $request->input('SubTotalProducto') / $request->input('cantidad'));
            $this->actualizartotalpedido($pedido->idPedido, $idMesa);
        } else {
            $pedido = DB::table('pedidos')->select('*')->where('idMesa', '=', $idMesa)->where('estPed', '=', '0')->get();
            $this->llenardetallepedido($request->input('idProducto'), $pedido[0]->idPedido, $request->input('cantidad'), $request->input('SubTotalProducto'), $idMesa,  $request->input('SubTotalProducto') / $request->input('cantidad'));
            $this->actualizartotalpedido($pedido[0]->idPedido, $idMesa);
            // $todosDetallePedido = DB::table('detallepedido')->select('*')->where('idPedido', '=', $pedido[0]->idPedido)->get();
            // return $todosDetallePedido;
        }

        return redirect('/prueba/' . $id . '/' . $idMesa);
    }
    public function llenardetallepedido($idProducto, $idPedido, $cantidad, $subTotal, $idMesa, $preciounitario)
    {
        //llenamos la tabla detallepedido
        $detallePedido = new DetallePedido();
        $detallePedido->idProducto = $idProducto;
        $detallePedido->idPedido = $idPedido;
        $detallePedido->cantidad = $cantidad;
        $detallePedido->montSubDetPed = $subTotal;
        $detallePedido->preciounitario = $preciounitario;
        $detallePedido->save();

        $mesa = Mesa::find($idMesa);
        $mesa->ocupado = true;
        $mesa->save();



        // return $todosDetallePedido[0]->idPedido;
        // error_log($todosDetallePedido);
    }
    public function actualizartotalpedido($idPedido, $idMesa)
    {

        //actulizar el total de la tabla pedidos
        $sumatotal =   DetallePedido::where('idPedido', '=', $idPedido)
            ->select(DB::raw('SUM(montSubDetPed) as montSubDetPed'))
            ->get();
        if ($sumatotal[0]->montSubDetPed > 0) {
            $pedido = Pedido::find($idPedido);
            $pedido->subTotal = $sumatotal[0]->montSubDetPed;
            $pedido->save();
        } else {
            $pedido = Pedido::find($idPedido);
            $pedido->delete();
            $mesa = Mesa::find($idMesa);
            $mesa->ocupado = 0;
            $mesa->update();
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
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $idMesa)
    {
        // return $request->all();
        $detallePedido =  DetallePedido::find($request->input('idPedidoEditar'));
       
        $detallePedido->cantidad = $request->input('CantidadPedidoEditar');
        $detallePedido->montSubDetPed = $request->input('SubTotalPedidoEditar');
        $detallePedido->save();
        $this->actualizartotalpedido($detallePedido->idPedido, $idMesa);

        return redirect('/prueba/' . $id . '/' . $idMesa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy($idMesa, $idDetallePedido, $idPedido, $id)
    {
        $detallePedido = DetallePedido::find($idDetallePedido);
        $detallePedido->delete();
        $this->actualizartotalpedido($idPedido, $idMesa);
        // $ped = Pedido::find($idpedido);
        // $ped->delete();
        // $vacio = 0;
        // $todos = DB::table('productos')
        //     ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
        //     ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.NombreTipoProducto')
        //     ->where('productos.idTipoProducto', '=', $id)
        //     ->get();


        // $datos = DB::table('pedidos')
        //     ->join('productos', 'pedidos.idProducto', '=', 'productos.idProducto')
        //     ->select('pedidos.idPedido', 'productos.nombreProducto', 'productos.precio', 'pedidos.cantidad', 'pedidos.subTotal')
        //     ->where('pedidos.idMesa', '=', $idMesa)
        //     ->get();

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

        $todos = DB::table('productos')
            ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
            ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.NombreTipoProducto')
            ->where('productos.idTipoProducto', '=', $id)
            ->get();

        $datos = DB::table('productos')
            ->join('detallepedido', 'productos.idProducto', '=', 'detallepedido.idProducto')
            ->join('pedidos', 'detallepedido.idPedido', '=', 'pedidos.idPedido')
            ->join('mesas', 'pedidos.idMesa', '=', 'mesas.idMesa')
            ->select('detallepedido.idDetallePedido', 'productos.nombreProducto', 'detallepedido.cantidad', 'detallepedido.preciounitario', 'detallepedido.montSubDetPed', 'pedidos.idPedido')
            ->where('mesas.idMesa', '=', $idMesa)
            ->where('pedidos.estPed', '=', 0)
            ->get();
        count($datos) ? $vacio = 1 : $vacio = 0;
        $tipoProducto = DB::table('tipo_productos')->select('*')->get();

        return view('mostrarPedid')->with('id', $id)->with('todos', $todos)->with('idMesa', $idMesa)->with('datos', $datos)->with('vacio', $vacio)->with('tipo_productos', $tipoProducto);
    }
}
