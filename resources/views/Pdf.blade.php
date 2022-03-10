<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Reporte</title>
</head>


<body>

            <div class="card">
                <div class="card-body-center">
                    <div class="card-header text-center">
                        @foreach($pedido as $m)
                        Boleta : {{str_pad($m->idConsumo,4,"0", STR_PAD_LEFT)}}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Fecha : <?php

                                $aea = date("d/m/Y", strtotime($m->created_at));
                                echo $aea;
                                ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Hora : {{$m->hora}}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Mozo : {{$m->name}}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        Total : S/{{number_format($m->total,2)}}
                        @endforeach
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">SubTotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $o = 1;
                            foreach ($detalleventa as $val) { ?>
                                <tr>

                                    <th scope="row">{{$o}}</th>
                                    <td> {{$val->nombreProducto}}</td>
                                    <td> {{$val->preciounitario}}</td>
                                    <td> {{$val->cantidad}}</td>
                                    <td> {{$val->montSubDetPed}}</td>
                                </tr>
                            <?php $o++;
                            } ?>

                        </tbody>
                    </table>
                </div>
            </div>
  


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>