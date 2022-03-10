@extends('layouts.cuerpo')
@section('page_name')
Pedido
@endsection
@section('content')
<?php
$total = 0;
?>

<script type="text/javascript">
    function aa(NombrePedido, IdPedido, PrecioPedido, CantidadPedido, SubTotalPedido) {

        //   document.getElementById('NombrePedir').value = document.getElementById("b2").value;

        document.getElementById('NombrePedidoEditar').value = NombrePedido.value;
        document.getElementById('idPedidoEditar').value = IdPedido.value;
        document.getElementById('CantidadPedidoEditar').value = CantidadPedido.value;
        document.getElementById('PrecioPedidoEditar').value = PrecioPedido.value;
        document.getElementById('PrecioPed').value = PrecioPedido.value;
        document.getElementById('SubTotalPedidoEditar').value = SubTotalPedido.value;

    }
    validaredit = (num, length) => {

        if (length > 0 && length <= 150) {
            document.getElementById('SubTotalPedidoEditar').value = document.getElementById('CantidadPedidoEditar').value * document.getElementById('PrecioPedidoEditar').value
            document.getElementById('EditarPedido').disabled = !num;
        } else {
            document.getElementById('EditarPedido').disabled = true;
        }
    }
</script>
<div class="row">

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <img src="https://img.icons8.com/windows/32/000000/edit-online-order.png">
                Pedidos
                <div class="card-tools">
                    <span class="alert-link">
                        Mesa: {{$idMesa}}
                    </span>
                </div>
            </div>

            <div class="card-body">
                @if($vacio==1)
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-secondary opacity-7">#</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cantidad</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SubTotal</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $e = 1;
                        foreach ($datos as $ped) {
                            $total = $total + $ped->montSubDetPed;
                        ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="" id="IdPedido<?php echo $e ?>" value="{{$ped->idDetallePedido}}">
                                    <span class="text-secondary text-xs font-weight-bold">{{$e}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="" id="NombrePedido<?php echo $e ?>" value="{{$ped->nombreProducto}}">
                                    <span class="text-secondary text-xs font-weight-bold">{{$ped->nombreProducto}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="" id="PrecioPedido<?php echo $e ?>" value="{{$ped->preciounitario}}">
                                    <span class="text-secondary text-xs font-weight-bold">S/.{{$ped->preciounitario}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="" id="CantidadPedido<?php echo $e ?>" value="{{$ped->cantidad}}">
                                    <span class="text-secondary text-xs font-weight-bold">{{$ped->cantidad}}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="hidden" name="" id="SubTotalPedido<?php echo $e ?>" value="{{$ped->montSubDetPed}}">
                                    <span class="text-secondary text-xs font-weight-bold">S/.{{$ped->montSubDetPed}}</span>
                                </td>
                                @if(count($tipo_productos)>0)
                                <td class="align-middle text-center">
                                    <button onclick="aa(NombrePedido<?php echo $e ?>,IdPedido<?php echo $e ?>,PrecioPedido<?php echo $e ?>,CantidadPedido<?php echo $e ?>,SubTotalPedido<?php echo $e ?>)" type="button" class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="modal" data-bs-target="#ModalEditar">
                                        <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Editar
                                    </button>
                                    <a href="{{ url('/EliminarPedido/'.$idMesa.'/'.$ped->idDetallePedido.'/'.$ped->idPedido.'/'.$id) }}" class="btn btn-link text-danger text-gradient px-2 mb-0"><i class="far fa-trash-alt me-2"></i>Eliminar</a>
                                </td>
                                @else
                                <td></td>
                                <td></td>
                                @endif
                            </tr>
                        <?php
                            $e++;
                        }
                        ?>
                    </tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">Total:</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">S/.<?php echo number_format($total, 2) ?></span>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <div class="align-middle text-center pt-4 p-0">
                    @if( Auth::user()->isadmin ==1 )
                    <a href="{{ url('/cobrar/'.$idMesa) }}" class="btn btn-outline-info">Cobrar</a>
                    @endif
                </div>
                @else
                <div class="alert alert-info" role="alert">
                    Mesa Libre!
                </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <img src="https://img.icons8.com/carbon-copy/32/000000/food.png">
                    Pedir
                </h3>
            </div>

            <div class="card-title">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative;height: none; ">
                        <div>
                            <div class="row px-3">
                                <?php
                                foreach ($tipo_productos as $key) {
                                ?>
                                    <div class="col mt-4">
                                        <a href="{{ url('/prueba/'.$key->idTipoProducto.'/'.$idMesa) }}" class="btn btn-danger w-100">{{$key->NombreTipoProducto}}</a>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @yield('contenido')
            </div>
        </div>

    </div>

</div>
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <form action="/editarPedido/{{$id}}/{{$idMesa}}" method="POST">
        {{ csrf_field()}}
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar Pedido</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idPedidoEditar" name="idPedidoEditar" value="">
                    <input type="hidden" name="PrecioPed" id="PrecioPed">

                    <div class="form-group">
                        <label for="exampleInputPassword1">Nombre del Pedido</label>
                        <input type="text" class="form-control" name="NombrePedidoEditar" id="NombrePedidoEditar" readonly="false">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Precio del Pedido</label>
                        <input type="number" class="form-control" name="PrecioPedidoEditar" id="PrecioPedidoEditar" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Cantidad del Pedido</label>
                        <input type="number" class="form-control" name="CantidadPedidoEditar" id="CantidadPedidoEditar" min=0 max=150 onkeyup="validaredit(document.getElementById('SubTotalPedidoEditar').value>0 , document.getElementById('CantidadPedidoEditar').value)" onclick="validaredit(document.getElementById('SubTotalPedidoEditar').value>0 , document.getElementById('CantidadPedidoEditar').value)">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">SubTotal del Pedido</label>
                        <input type="number" class="form-control" name="SubTotalPedidoEditar" id="SubTotalPedidoEditar" readonly="false">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-primary"" value=" Enviar" id="EditarPedido">
                </div>
            </div>

        </div>
    </form>
</div>


@endsection