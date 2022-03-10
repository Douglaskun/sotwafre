@extends('layouts.cuerpo')
@section('content')
<div class="row">
    <div class="col-lg-12 col-12 card">
        <div class="card-body">
            <div class="card-head">
                <h4>
                    Mesa: {{$idMesa}}
                </h4>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>

                        <th scope="col">subTotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $u = 1;
                    $tot = 0; ?>
                    @foreach($pedi as $val)
                    <tr>
                        <td>{{$u}}</td>
                        <td>{{$val->nombreProducto}}</td>
                        <td>{{$val->precio}}</td>
                        <td>{{$val->cantidad}}</td>
                        <td>{{$val->subTotal}}</td>
                    </tr>

                    <?php $u++;
                    $tot = $tot + $val->subTotal; ?>
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-align: right"><a href="{{ url('/registrarConsumo/'.$idMesa) }}" class="btn btn-outline-info">Cobrar</a></td>
                        <th style="text-align:center;">TOTAL:</th>
                        <th style="text-align: left">S/.{{number_format($tot,2)}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
