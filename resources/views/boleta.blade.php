@extends('layouts.cuerpo')
@section('page_name')
Boleta
@endsection
@section('content')
<script>
    habilitarBuscar = (aea) => {
        // console.log(aea)
        if (aea.length == 8) {
            document.getElementById('buscarComensal').disabled = false
        } else {
            document.getElementById('buscarComensal').disabled = true

        }
    }
</script>
<style>
    select {
        background: transparent;
        border: none;
        font-size: 14px;
        height: 30px;
        padding: 5px;
        width: 250px;
    }
</style>

<div class="container">
    <div class="card mt-2">
        <h5 class="card-header">Datos del Cliente</h5>
        <div class="card-body">
            <form action="/buscarComensal/{{$idMesa}}" method="POST" autocomplete="off">
                @if(isset($message))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{$message}} <a href="{{ url('/comensal') }}" class="alert-link">aquí</a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> @else
                @endif
                @csrf
                <div class="form-group row">
                    <input class="col-sm-4 col-form-label ml-4 rounded" type="search" type="number" placeholder="Buscar Dni" id='DniComensal' onkeyup="habilitarBuscar(document.getElementById('DniComensal').value)" name="DniComensal" aria-label="Search" value="<?php echo count($comensal) > 0  ? $comensal[0]->dniCome : ''; ?>">
                    <button class="btn btn-outline-info col-sm-2 ml-4" type="submit" id="buscarComensal" disabled>Buscar</button>

                </div>
            </form>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label ml-4">Dni</label>
                <div class="col-sm-7">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo count($comensal) > 0 ? $comensal[0]->dniCome : ''; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label ml-4">Nombre</label>
                <div class="col-sm-7">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo count($comensal) > 0 ? $comensal[0]->nomCome : ''; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label ml-4">Apellidos</label>
                <div class="col-sm-7">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo count($comensal) > 0 ? $comensal[0]->apeCome : ''; ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header pb-0 px-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-0">Datos de la mesa</h6>
                </div>
            </div>
        </div>
        <div class="table-responsive p-0">
            <div class="card-body pt-4 p-3">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-secondary opacity-7">#</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($detallepedido as $key) {
                        ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{$i}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{$key->nombreProducto}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">S/{{$key->preciounitario}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{$key->cantidad}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">S/{{$key->montSubDetPed}}</span>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="4" class="  text-right ">
                                <?php
                                if (count($comensal) > 0) {
                                ?>
                                    <a href="{{ url('/crearboleta/'.$pedido[0]->idPedido.'/'. $comensal[0]->idComensal) }}" class="btn btn-outline-info">Cobrar</a>
                                <?php
                                } else {

                                ?>
                                    <p class="text-danger">Debe buscar un cliente</p>
                                <?php
                                }
                                ?>
                            </td>
                            <td>Total S/ {{$pedido[0]->subTotal}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection