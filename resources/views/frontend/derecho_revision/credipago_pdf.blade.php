<title>Sistema SIGCAP</title>

<style>
    @page {
		margin-left: 2.5cm;
		margin-right: 2.5cm;
	}
    .container {
    position: relative;
    height: 100vh; /* Establece la altura del contenedor al 100% de la altura de la ventana del navegador */
    left: 570px;
    top: -100px;
}
.two-columns {
        column-count: 2;      /* Divide el contenido en dos columnas */
        column-gap: 40px;    /* Espacio entre las dos columnas */
    }

.vertical-text {
    position: absolute;
    top: ;
    right: 0;
    writing-mode: vertical-rl; /* Texto orientado verticalmente de derecha a izquierda */
    transform: rotate(90deg); /* Gira el texto 180 grados para que esté orientado de arriba hacia abajo */
    transform-origin: top right; /* Define el punto de origen de la transformación */
    text-align: justify;
    white-space: nowrap; /* Evita que el texto se rompa */
    color: black; /* Asegúrate de que el color del texto sea visible */
}
/*
.datepicker {
  z-index: 1600 !important; 
}
*/
/*.datepicker{ z-index:99999 !important; }*/

.datepicker,
.table-condensed {
  width: 250px;
  height:250px;
}
.p{
    font-size: 8.5;
}


.modal-dialog {
	width: 100%;
	max-width:60%!important
  }
  
#tablemodal{
    border-spacing: 0;
    display: flex;/*Se ajuste dinamicamente al tamano del dispositivo**/
    max-height: 80vh; /*El alto que necesitemos**/
    overflow-y: auto; /**El scroll verticalmente cuando sea necesario*/
    overflow-x: hidden;/*Sin scroll horizontal*/
    table-layout: fixed;/**Forzamos a que las filas tenga el mismo ancho**/
    width: 98vw; /*El ancho que necesitemos*/
    border:1px solid #c4c0c9;
}

#tablemodal thead{
    background-color: #e2e3e5;
    position: fixed !important;
}


#tablemodal th{
    border-bottom: 1px solid #c4c0c9;
    border-right: 1px solid #c4c0c9;
}

#tablemodal th{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 10px;
	font-weight:bold;
    height: 3.5vh !important;
	line-height:12px;
	vertical-align:middle;
	/*height:20px;*/
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal td{
    font-weight: normal;
    margin: 0;
    max-width: 9.5vw; 
    min-width: 9.5vw;
    word-wrap: break-word;
    font-size: 11px;
    height: 3.5vh !important;
    padding: 4px;
    border-right: 1px solid #c4c0c9;
}

#tablemodal tbody tr:hover td, #tablemodal tbody tr:hover th {
  /*background-color: red!important;*/
  font-weight:bold;
  /*mix-blend-mode: difference;*/
  
}

#tablemodalm{
	
}
</style>


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />


<script type="text/javascript">

$(document).ready(function() {
	//$('#hora_solicitud').focus();
	//$('#hora_solicitud').mask('00:00');
	//$("#id_empresa").select2({ width: '100%' });
});
</script>

<script type="text/javascript">





</script>


<body class="hold-transition skin-blue sidebar-mini">

    <div>
        <img width="200px" height="80px" style="top:-30px" src="img/logo_encabezado.jpg">
    </div>
    <div class="container">
    <div class="vertical-text" style="position: absolute; top: 0; right: 0; writing-mode: vertical-lr;">
    <div style="display: inline-block; white-space: nowrap; font-weight: bold;">IMPORTANTE.-</div>
        <div style="display: inline-block; white-space: nowrap;">Esta liquidaci&oacute;n y su comprobante de pago adjuntarla al expediente</div>
    </div>
    </div>
    <!--<div style="display: flex !important; width:100%">
        <span style="width: 50%; ">Div 1</span>
        <span style="width: 50%; float: right;">Div 2</span>
    </div>-->
    <div style="text-align: center;">
        <span style="font_size: 12; margin-left: 3cm; font-weight: bold;"><?php echo $credipago;?></span>
        <span style="float: right; font_size: 8.5">Cod. Proyecto:</span>
    </div>
    <div style="text-align: center;">
        <span style="font_size: 8.5; margin-left: 3cm;">CREDIPAGO</span>
        <span style="float: right; font_size: 8.5">N° Certificado:</span>
    </div>
    <hr>

    <p style="font_size: 8.5;text-align:justify"><b>LIQUIDACION DE DERECHOS POR REVISION DE ANTEPROYECTOS Y PROYECTOS DE ARQUITECTURA</b></pack>
    
        <hr>
        <div class="contenido">
            <span style="font-size: 8.5;"><b>PROFESIONAL:</b><span style="padding-left: 96px;"> <?php echo $proyectista;?></span></span>
            <span style="float: right; font-size: 8.5"><b>N° CAP:</b><span style="padding-left: 40px;"> <?php echo $numero_cap;?></span></span>
            <p> <span style="font_size: 8.5; margin-left: 4.9cm;"><?php echo $tipo_proyectista;?></span></span></p>
            <p class="p"><b>NOMBRE DEL PROPIETARIO:</b><span style="padding-left: 18px;"> <?php echo $razon_social;?></span></p>
            <p class="p"><b>NOMBRE DE ANTEPROYECTO:</b><span style="padding-left: 10px;"> <?php echo $nombre;?></span></p>
            <p class="p"><b>DEPARTAMENTO/PROVINCIA/DISTRITO:</b> <?php echo $departamento;?>/<?php echo $provincia;?>/<?php echo $distrito;?></p>
            <p class="p"><b>UBICACION DEL INMUEBLE:</b> <span style="padding-left: 22px;"><?php echo $direccion;?></p>
            <p></p>
            <p class="p"><b>TIPO DE OBRA:</b></p>
            <p class="p"><b>USO DE EDIFICACION:</b></p>
            <p class="p"><b>INSTANCIA:</b> <?php echo $instancia;?></p>
            <p class="p"><b>COMISION TECNICA:</b> <?php echo $municipalidad;?></p>
            <span style="font_size: 8.5;"><b>TOTAL AREA TECHADA (Intervenida) (M2):</b> <?php echo $total_area_techada;?></span>
            <span style="float: right; font_size: 8.5"><b>N° de Revision:</b> <?php echo $numero_revision;?></span>
            <p class="p"><b>VALOR DE LA OBRA DECLARADO EN EL FUE: S/.</b> <?php echo $valor_obra;?></p>
            <!--<p class="p" style="text-align : right"><b>PORCENTAJE A APLICAR SOBRE VALOR DE OBRA <?php //echo $porcentaje;?>%:</b> <?php //echo $sub_total;?></p>   
            <p class="p" style="text-align : right"><b>+IGV:</b> <?php //echo $igv;?></p>
            <hr style="width:10%; margin-right: 1px;">
            <p class="p" style="text-align : right"><b>TOTAL:</b> <?php //echo $total;?></p>
            <p style="text-align : right; font-size : 10"><b>TOTAL A PAGAR:</b> <?php //echo $total;?></p>-->
            
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: right; width: 20%;"></td>
                        <td class="td" style ="text-align: right; width: 60%;"><b>PORCENTAJE A APLICAR SOBRE VALOR DE OBRA<?php echo $porcentaje;?>%:</b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($sub_total,2,'.',',');?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: right; width: 20%;"></td>
                        <td class="td" style ="text-align: right; width: 60%;"><b>+IGV:</b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($igv,2,'.',',');?></td>
                        
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <!--<td class="td" style ="text-align: left; width: 20%;"><?php //echo $tipo_liquidacion;?></td>-->
                        
                        <td class="td" style ="text-align: left; width: 55%;"><?php echo $tipo_liquidacion;?></td>
                        <td class="td" style ="text-align: right; width: 25%;"><b>TOTAL:</b></td>
                        <td class="td" style ="text-align: left; width: 5%; border-top: 1px solid black;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%; border-top: 1px solid black;"><?php echo number_format($total,2,'.',',');?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: right; width: 55%;"></td>
                        <td class="td" style ="text-align: right; width: 25%; font-size:14px"><b>TOTAL A PAGAR:</b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($total,2,'.',',');?></td>
                    </tr>
                </tbody>
            </table>

            <hr>
            <span style="font_size: 8.5;"><b>V.B</b></span>
            <span style="float: right; font_size: 8.5"><b>Recibido por:...................................................</b></span> 
            <br>
            <span style="font_size: 8.5;"><b>Fecha de Emisi&oacute;n: <?php echo $carbonDate;?> &nbsp; &nbsp; &nbsp; <?php echo $currentHour;?></b></span>
            <span style="float: right; font_size: 8.5"><b>N° DNI:.................................................</b></span>   
            <hr>
            <p class="p">Costo por devoluci&oacute;n: S/. 50.00 + 12% del valor del Derecho de Revisi&oacute;n por conceptos administrativos.</p>
            <p></p>
        </div>
    </div>
    <!-- /.content-wrapper -->
    
@push('after-scripts')

<script src="{{ asset('js/derecho_revision/lista.js') }}"></script>

@endpush

<script>

function showMessage() {
    return "hola";
}

function Unidades(num){

switch(num)
{
    case 1: return "UN";
    case 2: return "DOS";
    case 3: return "TRES";
    case 4: return "CUATRO";
    case 5: return "CINCO";
    case 6: return "SEIS";
    case 7: return "SIETE";
    case 8: return "OCHO";
    case 9: return "NUEVE";
}

return "";
}//Unidades()

function Decenas(num){

decena = Math.floor(num/10);
unidad = num - (decena * 10);

switch(decena)
{
    case 1:
        switch(unidad)
        {
            case 0: return "DIEZ";
            case 1: return "ONCE";
            case 2: return "DOCE";
            case 3: return "TRECE";
            case 4: return "CATORCE";
            case 5: return "QUINCE";
            default: return "DIECI" + Unidades(unidad);
        }
    case 2:
        switch(unidad)
        {
            case 0: return "VEINTE";
            default: return "VEINTI" + Unidades(unidad);
        }
    case 3: return DecenasY("TREINTA", unidad);
    case 4: return DecenasY("CUARENTA", unidad);
    case 5: return DecenasY("CINCUENTA", unidad);
    case 6: return DecenasY("SESENTA", unidad);
    case 7: return DecenasY("SETENTA", unidad);
    case 8: return DecenasY("OCHENTA", unidad);
    case 9: return DecenasY("NOVENTA", unidad);
    case 0: return Unidades(unidad);
}
}//Unidades()

function DecenasY(strSin, numUnidades) {
if (numUnidades > 0)
return strSin + " Y " + Unidades(numUnidades)

return strSin;
}//DecenasY()

function Centenas(num) {
centenas = Math.floor(num / 100);
decenas = num - (centenas * 100);

switch(centenas)
{
    case 1:
        if (decenas > 0)
            return "CIENTO " + Decenas(decenas);
        return "CIEN";
    case 2: return "DOSCIENTOS " + Decenas(decenas);
    case 3: return "TRESCIENTOS " + Decenas(decenas);
    case 4: return "CUATROCIENTOS " + Decenas(decenas);
    case 5: return "QUINIENTOS " + Decenas(decenas);
    case 6: return "SEISCIENTOS " + Decenas(decenas);
    case 7: return "SETECIENTOS " + Decenas(decenas);
    case 8: return "OCHOCIENTOS " + Decenas(decenas);
    case 9: return "NOVECIENTOS " + Decenas(decenas);
}

return Decenas(decenas);
}//Centenas()

function Seccion(num, divisor, strSingular, strPlural) {
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

letras = "";

if (cientos > 0)
    if (cientos > 1)
        letras = Centenas(cientos) + " " + strPlural;
    else
        letras = strSingular;

if (resto > 0)
    letras += "";

return letras;
}//Seccion()

function Miles(num) {
divisor = 1000;
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

strMiles = Seccion(num, divisor, "UN MIL", "MIL");
strCentenas = Centenas(resto);

if(strMiles == "")
    return strCentenas;

return strMiles + " " + strCentenas;
}//Miles()

function Millones(num) {
divisor = 1000000;
cientos = Math.floor(num / divisor)
resto = num - (cientos * divisor)

strMillones = Seccion(num, divisor, "UN MILLON DE", "MILLONES DE");
strMiles = Miles(resto);

if(strMillones == "")
    return strMiles;

return strMillones + " " + strMiles;
}//Millones()

function NumeroALetras(num) {
var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
    letrasCentavos: "",
    letrasMonedaPlural: '',//"PESOS", 'Dólares', 'Bolívares', 'etcs'
    letrasMonedaSingular: '', //"PESO", 'Dólar', 'Bolivar', 'etc'

    letrasMonedaCentavoPlural: "CENTAVOS",
    letrasMonedaCentavoSingular: "CENTAVO"
};

if (data.centavos > 0) {
    data.letrasCentavos = "CON " + (function (){
        if (data.centavos == 1)
            return Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular;
        else
            return Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural;
        })();
};

if(data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
if (data.enteros == 1)
    return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
else
    return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
}//NumeroALetras()

</script>



