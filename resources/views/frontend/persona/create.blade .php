<link rel="stylesheet" href="<?php echo URL::to('/') ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>

<style>
    .table-sortable tbody tr {
        cursor: move;
    }
	/*
    #global {        
        width: 95%;        
        margin: 15px 15px 15px 15px;     
        height: 380px !important;        
        border: 1px solid #ddd;
        overflow-y: scroll !important;
    }
	*/
	#global {
        height: 650px !important;
        width: auto;
        border: 1px solid #ddd;
		margin:15px
       /* background: #f1f1f1;*/
        /*overflow-y: scroll !important;*/
    }
	
    .margin{

        margin-bottom: 20px;
    }
    .margin-buscar{
        margin-bottom: 5px;
        margin-top: 5px;
    }

    /*.row{
        margin-top:10px;
        padding: 0 10px;
    }*/
    .clickable{
        cursor: pointer;   
    }

    /*.panel-heading div {
        margin-top: -18px;
        font-size: 15px;        
    }
    .panel-heading div span{
        margin-left:5px;
    }*/
    .panel-body{
        display: block;
    }
	
	.dataTables_filter {
	   display: none;
	}

</style>

@extends('frontend.layouts.app')

@section('title', __('labels.frontend.contact.box_title'))

@section('breadcrumb')
<ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Supervisi&oacute;n</li>
        </li>
    </ol>
@endsection

@section('content')

    <!--<ol class="breadcrumb" style="padding-left:120px;margin-top:0px">
        <li class="breadcrumb-item text-primary">Inicio</li>
            <li class="breadcrumb-item active">Consulta de Afiliados</li>
        </li>
    </ol>
    -->
    <div class="justify-content-center">
        
        <div class="card">

        <div class="card-body">

            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0 text-primary">
                        Consultar Persona <!--<small class="text-muted">Usuarios activos</small>-->
                    </h4>
                </div><!--col-->
            </div>

        <div class="row justify-content-center">
        
        <div class="col col-sm-12 align-self-center">

            <div class="card">
                <div class="card-header">
                    <strong>
                        <!--@lang('labels.frontend.lista_afiliacion.box_title')-->
						Lista de Personas
                    </strong>
                </div><!--card-header-->
				
				<div class="col-md-12" style="padding-top:10px">
					<input class="form-control" id="system-search" name="q" placeholder="Buscar ...">                        
				</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblSupervision" class="table table-hover table-sm">
                            <thead>
                            <tr style="font-size:13px">
                                <th>Tip Doc</th>
                                <th>Doc Identidad</th>
                                <th>Persona</th>
                                <th>F.Nacimiento</th>
                                <th>Sexo</th>
                                <th>Estado</th>
                                <!--<th class="text-right">Acciones</th>-->
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($persona as $row):
                                    //$afiliado = "";
                                    //$afiliado = $row->apellido_paterno." ".$row->apellido_materno.", ".$row->nombres;
                                ?>
                                    <tr style="font-size:13px">
                                        <td class="text-left"><?php echo $row->tipo_documento?></td>
                                        <td class="text-left"><?php echo $row->numero_documento?></td>
                                        <td class="text-left"><?php echo $row->persona?></td>                                    
                                        <td class="text-left"><?php echo date("d/m/Y", strtotime($row->fecha_nacimiento));?></td>
                                        <td class="text-left"><?php echo $row->sexo?></td>
                                        <td class="text-left"><?php echo $row->estado?></td>

                                        <!--<td class="text-right">
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Log Viewer Actions">
                                                <a href="" class="btn btn-sm btn-info">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                                <a href="" class="btn btn-sm btn-success">
                                                    <i class="fa fa-download"></i>
                                                </a>

                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-backdrop="false" data-target="#delete-log-modal" data-log-date="">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>-->
                                    </tr>
                                <?php endforeach;?>
                            
                                <!--<tr>
                                    <td colspan="11" class="text-center">
                                        <span class="badge badge-default">{{ __('log-viewer::general.empty-logs') }}</span>
                                    </td>
                                </tr>
                                -->
                            </tbody>
                        </table>
                    </div><!--table-responsive-->
                </div><!--card-body-->
            </div><!--card-->
        <!--</div>--><!--col-->
    <!--</div>--><!--row-->

@endsection

@push('after-scripts')
<script type="text/javascript">
$(document).ready(function () {
	$('#tblSupervision').DataTable({
		"dom": '<"top">rt<"bottom"flpi><"clear">'
		});
	$("#system-search").keyup(function() {
		   var dataTable = $('#tblSupervision').dataTable();
		   dataTable.fnFilter(this.value);
		}); 
});
</script>
@endpush
