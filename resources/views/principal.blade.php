@section('page_name')
    Inicio
@endsection
@extends('layouts.cuerpo')
@section('content')
<div class="row">
   
    @if( Auth::user()->isadmin ==1 )
     <li class="nav-item d-none d-lg-flex">
          <a class="nav-link" href="{{ url('/regismes') }}">
             <span class="btn btn-primary">+ Crear Mesa</span>
          </a>
     </li>     
    @endif
    
    @foreach($mesa as $value)
    @if($value->ocupado==0)
    <div class="col-lg-2 col-3">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h4>Mesa: {{$value->NumMesa}}</h4>
                <p>Atender</p>
            </div>
            <div class="icon">
                <i class="fas fa-utensils"></i>
            </div>
            <a href="{{ url('/AtenderMesa/'.$value->idMesa) }}" class="small-box-footer">Atender <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @else
    <div class="col-lg-2 col-3">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <div class="row">
                    <h4>Mesa: {{$value->NumMesa}}</h4>
                </div>

                <?php
                $totalMesa = 0;

                foreach ($dat as $va) {
                    if ($va->idMesa == $value->NumMesa) {
                        $totalMesa = $totalMesa + $va->subTotal;
                        echo 'Mozo: ' . $va->name;
                    }
                }

                ?>
                <p><?php echo 'S/' . number_format($totalMesa, 2) ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-utensils"></i>
            </div>
            <a href="{{ url('/AtenderMesa/'.$value->idMesa) }}" class="small-box-footer">Ver Pedidos <i class="fas fa-arrow-circle-right"></i></a>
        </div>

    </div>
    @endif
    @endforeach
</div>
@endsection