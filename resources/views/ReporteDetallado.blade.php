@extends('Reportes')
@section('reporte')
<?php
//  $TotalVentaPorDia = 0;
//  foreach ($reporte as $val)
//       $TotalVentaPorDia = $TotalVentaPorDia + $val->total;
//  
?>

<div class="card">
    @if(count($reporte)>0)
    <div class="card-header ">
        <?php
        $newfecha = date("d-m-Y", strtotime($fecha));


        ?>
        <tr>

            <div style="text-align: center; ">
                <td><b> Reporte : {{$newfecha}} </b></td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <!-- <td><b> Venta Total : S/</b></td> -->
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <!-- <td><a href="{{ url('/ObtenerPdfDiario/'.$newfecha) }}">Descargar Reporte Diario</i></a></td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td><a href="https://api.whatsapp.com/send?phone=51962699597&text=hola%20soy%20un%20cliente&source=&data=">Enviar <img src="https://img.icons8.com/color/19/000000/whatsapp.png"></a></td>
                 -->

            </div>
        </tr>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>

                    <th scope="col">Mesa</th>
                    <th scope="col">hora</th>
                    <th scope="col">Dni</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Total S/</th>
                    <th scope="col"><i class="fas fa-table"></i></th>
                </tr>


            </thead>

            <tbody>

                <?php
                $i = 1;
                foreach ($reporte as $key) {

                ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$key->NumMesa}}</td>
                        <td>{{$key->hora}}</td>
                        <td>{{$key->dniCome}}</td>
                        <td>{{$key->nomCome}} {{$key->apeCome}}</td>
                        <td>S/ {{$key->total}}</td>
                        <td><a href="{{url('DetalleBoleta/'.$key->idConsumo)}}"><i class="fas fa-angle-double-right"></i></td>
                    </tr>

                <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    @else


    <div class="card-header">

        <tr>
            <div style="text-align: center;">
                <td>Reporte : </td>

            </div>
        </tr>

        <div class="card-header">
            <div class="alert alert-info" role="alert">
                No hay registro de venta
            </div>
        </div>

    </div>

    @endif


    @endsection