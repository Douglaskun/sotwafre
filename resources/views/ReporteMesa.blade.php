@extends('Reportes')
@section('reporte')
<?php
$fecha = "";
$newfecha = date("d/m/Y", strtotime($fecha));
?>
<div class="card">
    <div class="card-header">
        <div style="text-align: center;">
            <tr>
                <td><b> Reporte de la Mesa {{$pedido[0]->NumMesa}} </b></td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                <td><b>Fecha{{ date("d/m/Y", strtotime($pedido[0]->created_at))}}</b> </td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td><b>Hora {{ $pedido[0]->hora}}</b> </td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td><b>Consumo total S/{{$pedido[0]->total}}</b></td>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td><b><a href="{{ url('/ObtenerPdf/'.$pedido[0]->idConsumo)}}" class="alert-link">Descargar PDF</a></b></td>

            </tr>
        </div>

    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>


                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">cantidad</th>
                <th scope="col">SubTotal</th>

            </tr>

        </thead>
        <tbody>
            <?php
            $u = 1;
            foreach ($detallepedido as $key) {


            ?>
                <tr>
                    <td>{{$u}}</td>
                    <td>{{$key->nombreProducto}}</td>
                    <td>S/ {{$key->preciounitario}}</td>
                    <td>{{$key->cantidad}}</td>
                    <td>S/ {{$key->montSubDetPed}}</td>
                </tr>
            <?php
                $u++;
            }

            ?>
        </tbody>
    </table>
</div>
@endsection