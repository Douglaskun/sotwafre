@extends('layouts.cuerpo')
@section('page_name')
Carta
@endsection
@section('content')
<!-- CSS Files -->
<link id="pagestyle" href="{{asset('argon_template/assets/css/argon-dashboard.css?v=2.0.1')}}" rel="stylesheet" />
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">Carta</h6>
                </div>
                <div class="table-responsive p-0">
                    <div class="card-body pt-4 p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary opacity-7">#</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1 ?>
                                @foreach($todoslosproductos as $val)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$i}}</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{$val->nombreProducto}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$val->precio}}</span>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection