<?php

namespace App\Http\Controllers;

use App\Mesa;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\TipoProducto;
use App\Pedido;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class ProductoController extends Controller
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
        $tipoProducto = DB::table('tipo_productos')->select('*')->get();
        $productos =  DB::table('productos')
            ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
            ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.idTipoProducto', 'tipo_productos.NombreTipoProducto')
            ->get();

        return view('registrar')->with('TipoProducto', $tipoProducto)->with('productos', $productos);
    }
    public  function prueba($id)
    {

        $todos = DB::table('productos')
            ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
            ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.NombreTipoProducto')
            ->where('productos.idTipoProducto', '=', $id)
            ->get();
        return view('mostrarPedid')->with('id', $id)->with('todos', $todos);
    }
    public  function prueba2($id, $idMesa)
    {
        // $user = Auth::user();
        // return $user->id;

        $vacio = 0;
        //Seleccionamos por productos por id del producto
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        request()->validate([
            'NombreProducto' => 'required|max:60',
            'PrecioProducto' => 'required|Integer|Min:1|Max:150',
            'cboTipoProducto' => 'required'


        ], [
            'NombreProducto.required' => 'El nombre no puede ir vacio',
            'NombreProducto.max' => 'El nombre no debe exceder de 60 caracteres',
            'PrecioProducto.required' => 'El Precio no puede estar vacio',
            'PrecioProducto.integer' => 'Debes ingresar numeros',
            'PrecioProducto.min' => 'El precio minimo debe ser S/1.00',
            'PrecioProducto.max' => 'El precio no debe superar de S/150.00',
            'cboTipoProducto.required' => 'El Tipo de Producto no puede ir vacio'
        ]);

        // if ($request->input('cbocomida') == "SELECCIONE...") {
        //     return "selecciona solo un tipo";
        // } else
        // if ($request->input('cbocomida') != "SELECCIONE...") {




        //     $datos = new Producto();
        //     $datos->nombreProducto = $request->input('NombreProducto');
        //     $datos->precio = $request->input('PrecioProducto');
        //     $datos->idTipoProducto =  $request->input('cbocomida');
        //     $datos->save();
        //     return view('registrar');
        // } else if ($request->input('cbobebida') != "SELECCIONE...") {


        $datos = new Producto();
        $datos->nombreProducto = $request->input('NombreProducto');
        $datos->precio = $request->input('PrecioProducto');
        $datos->idTipoProducto =  $request->input('cboTipoProducto');
        $datos->save();
        $tipoProducto = DB::table('tipo_productos')->select('*')->get();

        $productos =  DB::table('productos')
            ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
            ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.idTipoProducto', 'tipo_productos.NombreTipoProducto')
            ->get();
        return view('registrar')->with('TipoProducto', $tipoProducto)->with('message', 'Producto registrado con exito!')->with('productos', $productos);
        // } else {
        //     return "No seleccionaste nada";
        // }

        // error_log('todo ok');

        // return 'datosValidados';
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
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $producto = Producto::find($request->idProducto);
        $producto->nombreProducto = $request->nombre;
        $producto->precio = $request->precio;
        $producto->idTipoProducto = $request->cboTipoProducto;
        $producto->save();

        $tipoProducto = DB::table('tipo_productos')->select('*')->get();
        $productos =  DB::table('productos')
            ->join('tipo_productos', 'productos.idTipoProducto', '=', 'tipo_productos.idTipoProducto')
            ->select('productos.idProducto', 'productos.nombreProducto', 'productos.precio', 'tipo_productos.idTipoProducto', 'tipo_productos.NombreTipoProducto')
            ->get();

        return view('registrar')->with('TipoProducto', $tipoProducto)->with('productos', $productos)->with('message', 'Producto Editado Correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
