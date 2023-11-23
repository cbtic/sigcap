<style type="text/css">
body {
    background-color: #bdc3c7;
}

.table-fixed {
    width: 100%;
    background-color: #f3f3f3;
}

.table-fixed tbody {
    height: 200px;
    overflow-y: auto;
    width: 100%;
}

.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
    display: block;
}

.table-fixed tbody td {
    float: left;
}

.table-fixed thead tr th {
    float: left;
    background-color: #f39c12;
    border-color: #e67e22;
}

/* Begin - Overriding styles for this page */
.card-body {
    padding: 0 1.25rem !important;
}

.form-control-sm {
    line-height: 1.1 !important;
    margin: 0 !important;
}

.form-group {
    margin-bottom: 0.5rem !important;
}

.breadcrumb {
    padding: 0.2rem 2rem !important;
    margin-bottom: 0 !important;
}

.card-header {
    padding: 0.2rem 1.25rem !important;
}

.pesajeIngreso {
    line-height: 2.8;
}

.fecha_ingreso_salida {
    color: blue;
    font-size: 14px;
    font-style: italic;
	float:left
}

br {
    line-height: 30px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

ul.ui-autocomplete {
    z-index: 1100;
}

.btn-xsm {
    font-size: 11px !important;
}

/* End - Overriding styles for this page */
/*********************************************************/
.switch {
  position: relative;
  display: inline-block;
  width: 42px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.no {padding-right:3px;padding-left:0px;display:block;width:20px;float:left;font-size:11px;text-align:right;padding-top:5px}
.si {padding-right:0px;padding-left:3px;display:block;width:20px;float:left;font-size:11px;text-align:left;padding-top:5px}

.flotante {
    display:inline;
        position:fixed;
        bottom:0px;
        right:0px;
		z-index:1000
}
.flotanteC {
    display:inline;
        position:fixed;
        bottom:65px;
        right:0px;
}

label.form-control-sm{
	padding-left:0px!important;
	padding-right:0px;
	padding-top:5px!important;
	height:25px!important;
	/*line-height:10px!important*/
}
</style>

@stack('before-scripts')
@stack('after-scripts')

@extends('frontend.layouts.app')

@section('title', __('labels.frontend.afiliacion.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
    <li class="breadcrumb-item text-primary">Inicio</li>
    <li class="breadcrumb-item active">Tabla Maestra</li>
    </li>
</ol>
@endsection

@section('content')
<!--
    <ol class="breadcrumb" style="padding-left:120px;margin-top:0px;background-color:#355C9D">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Nueva Asistencia</li>
        </li>
    </ol>
    -->

<div class="justify-content-center">
    <!--<div class="container-fluid">-->

    <div class="card">

        <div class="card-body">
        
        <ul class="nav nav-pills">
					<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general">Datos Generales</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#laboral">Datos Laborales</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pdt">Datos PDT</a></li>
		</ul>

        

            <form class="form-horizontal" method="post" action="{{ route('frontend.manten.index')}}" id="frmMantenimiento" autocomplete="off">
                <div class="tab-content">

                    <div class="row justify-content-center" style="margin-top:15px">
                        <div class="col col-sm-12 align-self-center">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_maestra" id="id_maestra" value="0">

                            <div class="row">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div id="" class="row">                            
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                             <!--<div id="general" class="tab-pane fade in active" style="opacity:100">-->
                                                <div class="card">                                                    
                                                    <div class="card-header">
                                                        <div id="" class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <strong>                                                                   
                                                                    Datos de Persona
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="card-body" style="margin-top:15px;margin-bottom:15px">
                                                        <div style="clear:both"></div>
                                                            <livewire:persona-registration />
                                                        <div style="clear:both"></div>
                                                    </div>
                                                </div>                                            
                                        </div>
                                    </div>
                                    <br>
                                    <div id="" class="row">
                                    </div>
                                </div>                                
                            </div>


                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>Lista de Personas</strong>
                                        </div>
                                        <div class="row" style="padding:10px 20px 10px 20px;">
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <livewire:persona />
                                            </div>
                                        </div>
                                    </div>
                                </div>            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--col-->
            
        </div>
        <!--row-->
    @endsection

    @push('after-scripts')
    
    @endpush
