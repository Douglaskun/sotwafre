@section('page_name')
    Productos
@endsection
@extends('layouts.cuerpo')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-5 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Registrar producto</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form method="POST" autocomplete="off" class="mt-2 mb-2 ml-2 mr-2" action="{{route('RegistrarProductos')}}">
                        @csrf
                        @if(isset($message))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            {{$message}}
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> @else
                        @endif
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control" value="{{old('NombreProducto')}}" name="NombreProducto" aria-describedby="emailHelp" placeholder="Ingrese el nombre del producto" maxlength="150">
                            {!!$errors->first('NombreProducto','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Precio</label>
                            <input type="number" class="form-control" value="{{old('PrecioProducto')}}" step="0.01" name="PrecioProducto" placeholder="Precio del producto" min=0 max=150>
                            {!!$errors->first('PrecioProducto','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <div class="form-group">
                            <label>Tipo de Producto</label>

                            <div class="tab-content p-0">

                                <div>
                                    <select class="form-control" name="cboTipoProducto">
                                        <option value=""> Seleccione...</option>
                                        <?php
                                        foreach ($TipoProducto as $dat) {
                                        ?>
                                            <option value={{$dat->idTipoProducto}}>{{$dat->NombreTipoProducto}}</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            {!!$errors->first('cboTipoProducto','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Productos registrados</h6>
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo Producto</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($productos as $key) {
                                ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$i}}</span>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">{{$key->nombreProducto}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">S/ {{$key->precio}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$key->NombreTipoProducto}}</span>
                                        </td>

                                        <td class="align-middle text-center">
                                            <button type="button" class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="modal" data-bs-target="#editarproducto{{$key->idProducto}}">
                                                <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Editar
                                            </button>
                                            <a href="" class="btn btn-link text-danger text-gradient px-2 mb-0">
                                                <i class="far fa-trash-alt me-2"></i>Eliminar
                                            </a>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editarproducto{{$key->idProducto}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                            <form action="/editarproducto" method="POST">
                                                {{ @csrf_field()}}
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Editar Producto</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('CantidadProducto{{$i}}').value='', document.getElementById('SubTotalProducto{{$i}}').value='0'">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="idProducto" value="{{$key->idProducto}}">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Nombre</label>
                                                                <input type="text" class="form-control" name="nombre" required value="{{$key->nombreProducto}}" placeholder="Ingrese el nombre del producto" maxlength="150" />

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Precio</label>
                                                                <input type="number" class="form-control" name="precio" required value="{{$key->precio}}" id="PrecioProducto{{$i}}" placeholder="Precio del producto" min=0 max=150>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1">Tipo Producto</label>
                                                                <select name="cboTipoProducto" class="form-control" selected="1">
                                                                    <?php
                                                                    foreach ($TipoProducto as $dat) {
                                                                    ?>
                                                                        <option value="{{$dat->idTipoProducto}}" {{$key->idTipoProducto == $dat->idTipoProducto ?'selected="selected"':''}}>{{$dat->NombreTipoProducto}}</option>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                {!!$errors->first('cboTipoProducto','<small style=" color:red">
                                                                    :message
                                                                </small>')!!}
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="editarProducto{{$i}}" type="submit" class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <!-- End Modal -->
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>

@endsection