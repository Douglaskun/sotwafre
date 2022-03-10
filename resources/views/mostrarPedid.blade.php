@extends('VerPedido')

@section('contenido')
<table class="table align-items-center mb-0">
    <thead>
        <tr>
            <th class="text-center text-secondary opacity-7">#</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
        </tr>
    </thead>
    <script type="text/javascript">
        validar = (num, i) => {

            document.getElementById('enviarPedido' + i).disabled = !num;
        }
    </script>
    <tbody>
        <?php
        $i = 1;
        ?>
        @foreach($todos as $val)
        <tr>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{$i}}</span>
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{$val->nombreProducto}}</span>
            </td>
            <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{$val->precio}}</span>
            </td>
            <td class="align-middle text-center">
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#atenderpedido{{$val->idProducto}}">Elegir</button>
            </td>

            <div class="modal fade" id="atenderpedido{{$val->idProducto}}" tabindex="-1" role="dialog" aria-hidden="true">
                <form action="/atenderpedido/{{$id}}/{{$idMesa}}" method="POST">
                    {{ @csrf_field()}}
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Realizar Pedidos</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('CantidadProducto{{$i}}').value='', document.getElementById('SubTotalProducto{{$i}}').value='0'">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="idProducto" value="{{$val->idProducto}}">
                                <div class="form-group">
                                    <la>Nombre</label>
                                    <input type="text" class="form-control" disabled name="nombre" value="{{$val->nombreProducto}}" placeholder="Ingrese el nombre del producto" maxlength="150" />

                                </div>
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" class="form-control" name="precio" value="{{$val->precio}}" id="PrecioProducto{{$i}}" disabled placeholder="Precio del producto" min=0 max=150>
                                </div>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" name="cantidad" id="CantidadProducto{{$i}}" placeholder=" Ingrese la cantidad" min=0 max=150 onclick="document.getElementById('SubTotalProducto{{$i}}').value  = document.getElementById('CantidadProducto{{$i}}').value*document.getElementById('PrecioProducto{{$i}}').value" onkeyup="document.getElementById('SubTotalProducto{{$i}}').value  = document.getElementById('CantidadProducto{{$i}}').value*document.getElementById('PrecioProducto{{$i}}').value ,validar(document.getElementById('CantidadProducto{{$i}}').value>0 ,'{{$i}}')">
                                    {!!$errors->first('cantidad','<small style="color:red">
                                        :message
                                    </small>')!!}
                                </div>
                                <div class="form-group">
                                    <label>SubTotal</label>
                                    <input type="number" class="form-control" readonly="false" value="0" name="SubTotalProducto" id="SubTotalProducto{{$i}}" placeholder="Sub Total" min=0>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="document.getElementById('CantidadProducto{{$i}}').value='', document.getElementById('SubTotalProducto{{$i}}').value='0',validar(document.getElementById('CantidadProducto{{$i}}').value>0,'{{$i}}')">Cerrar</button>
                                <button id="enviarPedido{{$i}}" type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </tr>
        <?php
        $i = $i + 1;
        ?>
        @endforeach
    </tbody>
</table>
@endsection