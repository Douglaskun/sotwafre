<?php

namespace App\Http\Controllers;

use App\Mesa;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Comensal;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function VerRegister()
    {
        return view('registerMozo');
    }
    public function index()
    {
        // if (Auth::user()->isadmin == 2) {
        //     return view('pedidoscocinero');
        // } else {
        $mesa = Mesa::all();
        //return view('principal', ['mesa' => $mesa]);
        // \Debugbar::info($mesa);
        $datos = DB::table('mesas')
            ->join('pedidos', 'mesas.idMesa', '=', 'pedidos.idMesa')
            ->join('users', 'pedidos.idUsuario', '=', 'users.id')
            ->select('mesas.idMesa', 'mesas.NumMesa', 'mesas.ocupado', 'pedidos.subTotal', 'users.name')
            ->where('estPed', '=', 0)
            ->get();
        // return $datos;
        return view('principal', ['mesa' => $mesa])->with('dat', $datos);
        // }
        //  return $datos;
    }
    public function Principal()
    {
        return view('principal');
    }

    public function carta()
    {

        $todoslosproductos = Producto::all();
        // return $todoslosproductos;
        return view('carta')->with('todoslosproductos', $todoslosproductos);
    }
    public function dirigir()
    {

        $datos = Comensal::all();
        // return $datos;
        return view('comensal')->with('datos', $datos);
    }
    public function registrarComensal(Request $request)
    {
        request()->validate([
            'DniComensal' => 'required|max:8|min:8|unique:comensal,dniCome',
            'NombreComensal' => 'required|max:150',
            'ApellidoComensal' => 'required|max:150'
        ], [
            'DniComensal.unique' => 'El Dni ya esta registrado',
            'DniComensal.min' => 'El Dni no puede ser menor a 8 caracteres',
            'DniComensal.required' => 'El Dni es obligatorio',
            'DniComensal.max' => 'El Dni no puede ser mayor a 8 caracteres',
            'NombreComensal.required' => 'El Nombre es obligatorio',
            'NombreComensal.max' => 'El nombre no puede ser mayor a 150 caracteres',
            'ApellidoComensal.required' => 'El Apellido es obligatorio',
            'ApellidoComensal.max' => 'El apellido no puede ser mayor a 150 caracteres'
        ]);
        $comensal = new Comensal();
        $comensal->dniCome = $request->DniComensal;
        $comensal->nomCome = $request->NombreComensal;
        $comensal->apeCome = $request->ApellidoComensal;
        $comensal->save();
        $datos = Comensal::all();
        return view('/comensal')->with('message', 'Comensal registrado con exito!')->with('datos', $datos);
    }

    public function editarComensal(Request $request)
    {
        $comensal = Comensal::find($request->idComensal);
        $comensal->dniCome = $request->DniComensal;
        $comensal->nomCome = $request->NombreComensal;
        $comensal->apeCome = $request->ApellidoComensal;
        $comensal->save();

        $datos = DB::table('comensal')->get();
        return view('/comensal')->with('message', 'Comensal modificado con exito!')->with('datos', $datos);
    }

    public function pedidoscocinero()
    {
        return view('pedidoscocinero');
    }
}
