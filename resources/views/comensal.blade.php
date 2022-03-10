@extends('layouts.cuerpo')
@section('page_name')
    Comensal
@endsection
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-5 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Registrar comensal</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    @if(isset($message))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> @else
                    @endif
                    <form method="POST" class="mt-2 mb-2 ml-2 mr-2" autocomplete="off" action="{{route('registrarComensal')}}">
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">DNI</label>
                            <input type="text" class="form-control" value="{{old('DniComensal')}}" name="DniComensal" aria-describedby="emailHelp" placeholder="Ingrese su Dni" maxlength="8">
                            {!!$errors->first('DniComensal','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control" value="{{old('NombreComensal')}}" name="NombreComensal" aria-describedby="emailHelp" placeholder="Ingrese su Nombre" maxlength="150">
                            {!!$errors->first('NombreComensal','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Apellido</label>
                            <input type="text" class="form-control" value="{{old('ApellidoComensal')}}" name="ApellidoComensal" aria-describedby="emailHelp" placeholder="Ingrese su Apellido" maxlength="150">
                            {!!$errors->first('ApellidoComensal','<small style="color:red">
                                :message
                            </small>')!!}
                        </div>
                        <button type="submit" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Registrar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 mt-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Comensales registrados</h6>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-0">
                    <div class="card-body pt-4 p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary opacity-7">#</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dni</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombres</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Apellidos</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($datos as $key) {

                                ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$i}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$key->dniCome}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$key->nomCome}}</span>
                                        </td>
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">{{$key->apeCome }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <button type="button" class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="modal" data-bs-target="#editarComensal{{$key->idComensal}}">
                                                <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Editar
                                            </button>
                                            <a href="" class="btn btn-link text-danger text-gradient px-2 mb-0"><i class="far fa-trash-alt me-2"></i>Eliminar</a>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editarComensal{{$key->idComensal}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                            <form action="/editarComensal" method="POST" class="mt-2 mb-2 ml-2 mr-2">
                                                {{ @csrf_field()}}
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Editar Comensal</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="document.getElementById('CantidadProducto{{$i}}').value='', document.getElementById('SubTotalProducto{{$i}}').value='0'">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="idComensal" value="{{$key->idComensal}}">

                                                            <div class="form-group">
                                                                <label>Dni</label>
                                                                <input type="text" class="form-control" name="DniComensal" required value="{{$key->dniCome}}" placeholder="Ingrese numero de DNI" maxlength="8" />
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Nombre</label>
                                                                <input type="text" class="form-control" name="NombreComensal" required value="{{$key->nomCome}}" placeholder="Ingrese su nombre" maxlength="40">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Apellidos</label>
                                                                <input type="text" class="form-control" name="ApellidoComensal" required value="{{$key->apeCome}}" placeholder="Ingrese su apellido" maxlength="40">
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