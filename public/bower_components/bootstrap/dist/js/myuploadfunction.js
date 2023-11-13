$(function () {
    
    obtenerlista('iniciar');    
    
    $('#fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
           // $("tr:has(td)").remove();
           $("#uploaded-files").find("tr:gt(0)").remove();
            
            recargarlistaarchivos(data.result);
            
            document.getElementById("pregoresotexto").innerHTML = 'Progreso: Subido.';
            
        },
 
        progressall: function (e, data) {
            
            var progress = parseInt(data.loaded / data.total * 100, 10);
            
            $('#progress').css(
                'width',
                progress + '%'
            );
    
            document.getElementById("progress").innerHTML = progress + '%';
            document.getElementById("pregoresotexto").innerHTML = 'Progreso: Subiendo...';
            
        },
 
        dropZone: $('#dropzone')
    });
    
    /*
    $('#fileupload').bind('fileuploadprogressall', function (e, data) 
    {            
            var progress = parseInt(data.loaded / data.total * 100, 10);
            
            $('#progress').css(
                'width',
                progress + '%'
            );
    
            document.getElementById("progress").innerHTML = progress + '%';
            document.getElementById("pregoresotexto").innerHTML = 'Progreso: Subiendo';
    });*/
});


function obtenerlista(tipo)
{
    try {
        
    $.ajax({
    type:'GET',
    url: "/app_std/listararchivosinternooficina",
    dataType: 'json',
    success:function(data, status){
        
        console.log(data);
        
        recargarlistaarchivos(data);
        
        if(tipo=='eliminar')
        {
            document.getElementById("pregoresotexto").innerHTML = 'Progreso: Eliminado.';
        }
        
        },
    error:function(xhr, status, errorThrown){

        console.log(xhr);
        console.log(status);
        console.log(errorThrown);
    }

    });
    }     catch(err) {
        console.log(err.message);
    }
}

function recargarlistaarchivos(archivos)
{
    
   $("#uploaded-files").find("tr:gt(0)").remove();
    
            $.each(archivos, function (index, file) {
                $("#uploaded-files").append(
                        $('<tr style="word-break: break-all;" />')
                        .append($('<td/>').text(file.fileName))
                        .append($('<td/>').text(file.fileSize))
                        .append($('<td/>').text(file.fileType))
                        .append($('<td/>').html("<a href='/app_std/verarchivosinternooficina/"+index+"'>Click</a>"))
                         .append($('<td/>').html("<a onclick='eliminararchivo("+index+")'>Click</a>"))
                        )
            }); 
}

function eliminararchivo(id)
{
    document.getElementById("pregoresotexto").innerHTML = 'Progreso: Eliminando...';
    
    try {
        
    $.ajax({
    type:'POST',
    url: "/app_std/eliminararchivosinternooficina",
    data: { 
        'id': id, 
    },
    //dataType: 'json',
    success:function(data, status){

        obtenerlista('eliminar');
        
        },
    error:function(xhr, status, errorThrown){
        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Error al eliminar.';
        console.log(xhr);
        console.log(status);
        console.log(errorThrown);
    }

    });
    
    }     catch(err) {
        console.log(err.message);
        document.getElementById("pregoresotexto").innerHTML = 'Progreso: Error al eliminar.';
    }
}