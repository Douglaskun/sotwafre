@section('page_name')
    Reportes
@endsection
@extends('layouts.cuerpo')
@section('content')
<?php

?>
<style>
    /* Removes the clear button from date inputs */
    input[type="date"]::-webkit-clear-button {
        display: none;
    }

    /* Removes the spin button */
    input[type="date"]::-webkit-inner-spin-button {
        display: none;
    }

    /* Always display the drop down caret */
    input[type="date"]::-webkit-calendar-picker-indicator {
        color: #2c3e50;
    }

    /* A few custom styles for date inputs */
    input[type="date"] {
        appearance: none;
        -webkit-appearance: none;
        color: #95a5a6;
        font-family: "Helvetica", arial, sans-serif;
        font-size: 18px;
        border: 1px solid #ecf0f1;
        background: #ecf0f1;
        padding: 5px;
        display: inline-block !important;
        visibility: visible !important;
    }

    input[type="date"],
    focus {
        color: #95a5a6;
        box-shadow: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="mt-4">
            <div class="card">
                <div class="card-header pb-3 px-3">
                    <h6 class="mb-0">Reportes</h6>
                </div>
                <div class="card-body pt-3 p-3">
                    <form method="POST" action="/ConsultarReporteDiario">
                        @csrf
                        <div class="row">
                            <div class="col-2">
                                <p><small>Seleccione la fecha a consultar:</small></p>
                            </div>
                            <div class="col-3 d-flex">
                                <input class="form-control" name="FechaConsultar" type="date" value="<?php echo isset($fecha) ? $fecha : '' ?>">
                            </div>
                            <div class="col-7 text-end">
                                <button class="btn btn-primary w-25" type="submit">
                                    <span class="btn-inner--text">Consultar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @yield('reporte')
        </div>
    </div>
</div>
@endsection