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
    <!--<div class="container">
        <div class="vertical-text" style="position: absolute; top: 0; right: 65; writing-mode: vertical-lr;">
            <div style="display: inline-block; white-space: nowrap; font-weight: bold;">IMPORTANTE.-</div>
            <div style="display: inline-block; white-space: nowrap;">Esta liquidaci&oacute;n adjuntarla al certificado de habilitaci&oacute;n</div>
        </div>
    </div>-->
    <!--<div style="display: flex !important; width:100%">
        <span style="width: 50%; ">Div 1</span>
        <span style="width: 50%; float: right;">Div 2</span>
    </div>-->
    
    <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
            <tr>
                <td class="td" style ="text-align: right; width: 60%; font-size:16px"><b><?php echo $credipago;?></b></td>
                <td class="td" style ="text-align: left; width: 15%;"></td>
                <td class="td" style ="text-align: left; width: 20%;">Cod. Proyecto:</b></td>
                <td class="td" style ="text-align: right; width: 5%;"><?php echo $codigo;?></td>                
            </tr>
            <tr>
                <td class="td" style ="text-align: right; width: 60%;">CREDIPAGO</td>
                <td class="td" style ="text-align: left; width: 15%;"></td>
                <td class="td" style ="text-align: left; width: 20%;"></b></td>
                <td class="td" style ="text-align: right; width: 5%;"><?php //echo $credipago;?></td>                
            </tr>
        </tbody>
    </table>
    <hr>
   
    <p style="font_size: 8.5;text-align:justify"><b>LIQUIDACION DE DERECHOS POR REVISION Y CALIFICACION DE PROYECTOS DE HABILITACION URBANA</b></p>
    
        <hr>
        <div class="contenido">
            
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px; vertical-align:top">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 44%;"><b>ARQUITECTO:</b></td>
                        <td class="td" style ="text-align: left; width: 41%;"><?php foreach($proyectista_nombres as $nombres):?>
                                                                                <?= ($nombres) ?> <br>
                                                                                <?php endforeach;?>
                                                                                </td>
                        <td class="td" style ="text-align: right; width: 7%; font-size:11px; height:25px;"><b>N° CAP</b></td>
                        <td class="td" style ="text-align: right; width: 8%; font-size:11px; height:25px"><?php foreach($proyectista_cap as $cap):?>
                                                                                                            <?= ($cap) ?> <br>
                                                                                                            <?php endforeach;?>
                                                                                                            </td>
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%; font-size:11px; height:25px"></td>
                        <td class="td" style ="text-align: left; width: 45%; font-size:11px; height:25px"><?php echo $tipo_proyectista;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%; height:25px"><b>NOMBRE DEL PROPIETARIO:</b></td>
                        <td class="td" style ="text-align: left; width: 45%; height:25px"><?php foreach($propietario_nombres as $propietario):?>
                                                                                                            <?= ($propietario) ?> <br>
                                                                                                            <?php endforeach;?>
                                                                                                            </td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%; height:25px"><b>DENOMINACION DE <?php echo $tipo_tramite;?>:</b></td>
                        <td class="td" style ="text-align: left; width: 45%; height:25px"><?php echo $nombre;?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height:5px;"></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%;"><b>DEPARTAMENTO/PROVINCIA/DISTRITO:</b></td>
                        <td class="td" style ="text-align: left; width: 45%;"><?php echo $departamento;?>/<?php echo $provincia;?>/<?php echo $distrito;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%;"><b>INSTANCIA:</b></td>
                        <td class="td" style ="text-align: left; width: 45%;"><?php echo $instancia;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%;"><b>COMISION TECNICA:</b></td>
                        <td class="td" style ="text-align: left; width: 45%;"><?php echo $municipalidad;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 35%;"><b>DIRECCION:</b></td>
                        <td class="td" style ="text-align: left; width: 45%;"><?php echo $id_sitio.' '.$sitio_descripcion.' '.$id_zona.' '.$zona_descripcion.' '.($parcela ? 'PARCELA: ' . $parcela . ' ' : '') .' '.($super_manzana ? 'SUPER MANZANA: ' . $super_manzana . ' ' : '').' '.$id_tipo.' '.$direccion.' '.($lote ? 'LOTE: ' . $lote . ' ' : '').' '.($sub_lote ? 'SUB LOTE: ' . $sub_lote . ' ' : '').' '.($fila ? 'FILA: ' . $fila . ' ' : '').' '.($zonificacion ? 'ZONIFICACION: ' . $zonificacion . ' ' : '');?></td>
                    </tr>
                </tbody>
            </table>

            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <td colspan="2" style="height:5px;"></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 44%; height:25px"><b>AREA BRUTA DEL TERRENO (m2):</b></td>
                        <td class="td" style ="text-align: left; width: 36%; height:25px"><?php echo number_format($total_area_techada, 2, '.', ',');?></td>
                        <td class="td" style ="text-align: left; width: 15%; height:25px"><b>N° de Revision:</b></td>
                        <td class="td" style ="text-align: right; width: 5%; height:25px"><?php echo $numero_revision;?></td>
                    </tr>
                </tbody>
            </table>
           
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: center; width: 80%;"><b>FACTOR A APLICAR SOBRE EL AREA DEL TERRENO ES <?php echo number_format($valor_metro_cuadrado,3,'.',',');?></b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($sub_total, 2, '.', ',');?></td>
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>   
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;"><b>Monto Minimo (inc. IGV):</b></td>
                        <td class="td" style ="text-align: left; width: 20%;">S/ <?php echo number_format($valor_minimo,2,'.',',');?></td>
                        <td class="td" style ="text-align: right; width: 35%;"><b>+IGV:</b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($igv,2,'.',',');?></td>
                        
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto; font-size:12px">
                <tbody>
                    <tr>
                        <!--<td class="td" style ="text-align: left; width: 20%;"><?php //echo $tipo_liquidacion;?></td>-->
                        
                        <td class="td" style ="text-align: left; width: 25%;"><b>Monto Maximo (inc. IGV):</b></td>
                        <td class="td" style ="text-align: left; width: 20%;">S/ <?php echo number_format($valor_maximo,2,'.',',');?></td>
                        <td class="td" style ="text-align: right; width: 35%;"><b>TOTAL:</b></td>
                        <td class="td" style ="text-align: left; width: 5%; border-top: 1px solid black;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%; border-top: 1px solid black;"><?php echo number_format($total,2,'.',',');?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%; font-size:10px"><i>CALCULADO POR EL SISTEMA</i></td>
                        <td class="td" style ="text-align: left; width: 20%;"></td>
                        <td class="td" style ="text-align: right; width: 35%; font-size:14px"><b>TOTAL A PAGAR:</b></td>
                        <td class="td" style ="text-align: left; width: 5%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 15%;"><?php echo number_format($total,2,'.',',');?></td>
                    </tr>
                </tbody>
            </table>

            <hr>
            <span style="font_size: 8.5;">V.B</span>
            <span style="float: right; font_size: 8.5"><b>Recibido por:...................................................</b></span> 
            <br>
            <span style="font_size: 8.5;">Fecha de Emisi&oacute;n: <?php echo $carbonDate;?> &nbsp; &nbsp; &nbsp; <?php echo $currentHour;?></span>
            <span style="float: right; font_size: 8.5"><b>N° DNI:...................................................</b></span>   
            <hr>
            <p class="p">En caso de devolucion, se le deducir&aacute; gastos bancarios y administrativos, comisi&oacute;n Niubiz segun corresponda.</p>
            <p class="p">Costo por devoluci&oacute;n: S/. 50.00 soles por conceptos administrativos.</p>
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



