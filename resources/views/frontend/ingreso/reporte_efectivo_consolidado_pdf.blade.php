<title>Sistema SIGCAP</title>

<style>
    @page {
		margin-left: 2.5cm;
		margin-right: 2.5cm;
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

.contenido_encabezado{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: center;
    font-size: 18px !important;
}

.contenido_encabezado_cap{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: center;
    font-size: 16px !important;
}

.contenido_cuerpo{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: justify;
    font-size: 16px;
}

.contenido_pie{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: justify;
    font-size: 12px;
    margin-left:40px;
    margin-right:40px;
}

.info_pie{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: center;
    font-size: 12px;
}

.detalle_pie_pagina{
    font-family: 'Arial MT', Arial, sans-serif;
    text-align: left;
    font-size: 11px;
    width: 100%; position: fixed;
    bottom: 0;
    border-top: 1px solid #ccc;
    padding: 10px 0;
    color: #555;
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
        <div style="text-align: right; height: 100px; position: relative;">
            <img width="196px" height="58px" style="margin-top:50px;" src="img/logo_cap.jpg">
            <div>
                <h2 style="text-align:center">RECAUDACIÓN EN EFECTIVO - CONSOLIDADO</h2>
                <p style="text-align:center">Recaudación del día <?php echo $fecha;?></p>
                <p style="text-align:center">Cajero: AREVALO IPANAQUE MELLANY GLEENDA</p>
            </div>
            <table class="data" style="border-collapse: separate; border-spacing: 0; background-color:white !important; width: 100%; border-radius: 8px; font-size:11px">
                <tbody>
                    <tr class="data">
                        <td class="td" style ="text-align: left; width: 30%; height:25px; border-bottom: 1px solid black;"><b>INGRESOS EN EFECTIVO</b></td>
                        <td class="td" colspan ="2" style ="text-align: center; width: 15%; height:25px; border-bottom: 1px solid black;"><b>NUEVOS SOLES S/.</b></td>
                        <td class="td" colspan ="2" style ="text-align: center; width: 15%; height:25px; border-bottom: 1px solid black;"><b>DOLARES AMERICANOS US$</b></td>
                    </tr>
                    <tr class="data">
                        <td class="td" style ="text-align: left; width: 30%; height:25px; border-bottom: 1px solid black;"><b>DENOMINACI&Oacute;N</b></td>
                        <td class="td" style ="text-align: right; width: 15%; height:25px; border-bottom: 1px solid black;"><b>CANTIDAD</b></td>
                        <td class="td" style ="text-align: right; width: 15%; height:25px; border-bottom: 1px solid black;"><b>IMPORTE S/.</b></td>
                        <td class="td" style ="text-align: right; width: 15%; height:25px; border-bottom: 1px solid black;"><b>CANTIDAD</b></td>
                        <td class="td" style ="text-align: right; width: 15%; height:25px; border-bottom: 1px solid black;"><b>IMPORTE US$</b></td>
                    </tr>
                    
                    <?php 
                    $total_general_soles=0;
                    $total_general_dolares=0;
                    foreach($datos as $key=>$r) { 
                        ?>
                        <tr>
                            <td class="td" style ="text-align: left; width: 30%; height:25px"><?php echo $r->descripcion_soles;?></td>
                            <td class="td" style ="text-align: right; width: 15%; height:25px"><?php echo $r->cantidad_soles;?></td>
                            <td class="td" style ="text-align: right; width: 12%; height:25px"><?php echo number_format($r->total_soles,2,'.',',');?></td>
                            <td class="td" style ="text-align: right; width: 15%; height:25px"><?php echo $r->cantidad_dolares;?></td>
                            <td class="td" style ="text-align: right; width: 15%; height:25px"><?php echo number_format($r->total_dolares,2,'.',',');?></td>
                            <?php 
                            $total_general_soles+=$r->total_soles;
                            $total_general_dolares+=$r->total_dolares;
                            ?>
                        </tr>
                    <?php 
                    }
                    ?>
                    <tr>
                        <td class="td" style ="text-align: center; width: 30%; height:25px"><b>TOTAL GENERAL</b></td>
                        <td class="td" colspan="2" style ="text-align: right; width: 12%; height:25px"><b><?php echo number_format($total_general_soles,2,'.',',');?></b></td>
                        <td class="td" colspan="2" style ="text-align: right; width: 12%; height:25px"><b><?php echo number_format($total_general_dolares,2,'.',',');?></b></td>
                    </tr>
                </tbody>
            </table>
            <br><br><br><br><br>
            <table class="data" style="border-collapse: separate; border-spacing: 25px 0px; background-color:white !important; width: 100%; border-radius: 8px; font-size:11px">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: center; width: 50%; height:25px"></td>
                        <td class="td" style ="text-align: center; width: 50%; height:25px; font-size:12px; border-top:1px solid #000000;">ENTREGADO POR: AREVALO IPANAQUE MELLANY GLEENDA</td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: center; width: 50%; height:25px"></td>
                        <td class="td" style ="text-align: center; width: 50%; height:25px; font-size:12px">Encargado de Caja</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.content-wrapper -->
    
@push('after-scripts')

<script src="{{ asset('js/certificado.js') }}"></script>

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



