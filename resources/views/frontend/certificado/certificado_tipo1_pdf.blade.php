<title>Sistema SIGCAP</title>

<style>
    @page {
		margin-left: 2cm;
		margin-right: 2cm;
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

.td{
    font-size: 15px;
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
    <h3 style="text-align:center">CERTIFICADO DE HABILITACI&Oacute;N PROFESIONAL</h3>
        <p  style="text-align:center; font_size: 11">PARA EL TR&Aacute;MITE DE APROBACI&Oacute;N DE
        ANTEPROYECTO Y/O PROYECTO ARQUITECT&Oacute;NICO</p>
        <p style="text-align:center">  N° : <?php echo $datos[0]->codigo;?> </p>
        <hr>
        <div class="contenido">
            <!--<p id="primero">La Regional Lima del Colegio de Arquitectos del Perú, certifica que:</p>-->
            <p style="margin-left: 0cm; font_size: 11"><?php echo $tratodesc;?> <?php "   "?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <?php echo $datos[0]->desc_cliente;?> </p>
            <div style="text-align: center;">
                <span style="float: left; font_size: 11">COLEGIATURA N° CAP&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <?php echo $datos[0]->numero_cap;?></span>
                <span style="float: right; font_size: 11">INSCRIPCI&Oacute;N&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <?php echo $datos[0]->numero_regional;?></span>
            </div>
            
            
            <p style="margin-top: 50px; font_size: 11">SE ENCUENTRA <?php echo $habilita;?> PARA EL EJERCICIO PROFESIONAL EN CALIDAD DE PROYECTISTA</p>
            <p style="font_size: 11">I. INFORMACI&Oacute;N GENERAL DEL PROYECTO</p>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 95%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; height: 35px;" >1. PROYECTISTA(S) ASOCIADOS:</td>
                        <td class="td" style ="text-align: left; height: 35px;"><?php echo $nombre_proyectista;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 35px;">2. NOMBRE DEL PROPIETARIO:</td>
                        <td class="td" style ="text-align: left; height: 35px;"><?php echo $nombre_propietario;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 35px;">3. DENOMINACI&Oacute;N DEL PROYECTO:</td>
                        <td class="td" style ="text-align: left; height: 35px;"><?php echo $nombre_proyecto;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 35px;">4. UBICACI&Oacute;N:</td>
                        <td class="td" style ="text-align: left; height: 35px;"></td>
                    </tr>
                </tbody>
            </table>
            
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 95%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; height: 30px;">Departamento: <?php echo $departamento;?></td>
                        <td class="td" style ="text-align: left; height: 30px;">Provincia: <?php echo $provincia;?></td>
                        <td class="td" style ="text-align: left; height: 30px;">Distrito: <?php echo $distrito;?></td>
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 95%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 15%; height: 30px;">Direcci&oacute;n:</td>
                        <td class="td" style ="text-align: left; width: 75%; height: 30px;"><?php echo $direccion_proyecto;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 15%; height: 30px;">Lugar:</td>
                        <td class="td" style ="text-align: left; width: 75%; height: 30px;"><?php echo $lugar_proyecto;?></td>
                    </tr>
                </tbody>
            </table>
            <p style="font_size: 11">II. DATOS T&Eacute;CNICOS DEL ANTEPROYECTO</p>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;">1. Valor Unitario M2:</td>
                        <td class="td" style ="text-align: left; width: 25%;"><?php echo $valor_unit;?> </td>
                        <td class="td" style ="text-align: left; width: 25%;">&Aacute;rea de Terreno:</td>
                        <td class="td" style ="text-align: right; width: 3%;"></td>
                        <td class="td" style ="text-align: right; width: 21%;"><?php echo $valor_unit;?></td>
                        <td class="td" style ="text-align: right; width: 3%;">M2</td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;"></td>
                        <td class="td" style ="text-align: left; width: 25%;"></td>
                        <td class="td" style ="text-align: left; width: 25%;">Valor Total de la Obra:</td>
                        <td class="td" style ="text-align: right; width: 3%;">S/.</td>
                        <td class="td" style ="text-align: right; width: 21%;"><?php echo $valor_unit;?></td>
                        <td class="td" style ="text-align: right; width: 3%;"></td>
                    </tr>
                </tbody>
            </table>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 100%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;">2. Tipo Obra:</td>
                        <td class="td" style ="text-align: left; width: 25%;"><?php echo $tipo_obra;?></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 15%;">Zonif.</td>
                        <td class="td" style ="text-align: left; width: 10%;"><?php echo $zonificacion;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;">3. Uso Edificaci&oacute;n:</td>
                        <td class="td" style ="text-align: left; width: 25%;"><?php echo $tipo_uso_;?></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 15%;">Num.Vivienda:</td>
                        <td class="td" style ="text-align: right; width: 10%;"><?php //echo $valor_unit;?></td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; width: 25%;">4. &Aacute;rea Techada:</td>
                        <td class="td" style ="text-align: left; width: 25%;"></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 12.5%;"></td>
                        <td class="td" style ="text-align: left; width: 15%;">Num.Pisos:</td>
                        <td class="td" style ="text-align: right; width: 10%;"><?php //echo $valor_unit;?></td>
                    </tr>
                </tbody>
            </table>
            <p></p>
            
            <!--<p style="text-align: center; font_size: 11" >Sotano(s): <?php //echo $sotanos_m2;?> </p>  
            <p style="text-align: center; font_size: 11" >Semi sotano(s): <?php //echo $semisotano_m2;?> </p>  
            <p style="text-align: center; font_size: 11" >Primer Piso o nivel: <?php //echo $piso_nivel_m2;?> </p>  
            <p style="text-align: center; font_size: 11" >Otros Pisos o nivel: <?php //echo $otro_piso_nivel_m2;?> </p>  
            <hr style="width:50%">
            <p style="text-align: center; font_size: 11" >Total Area Techada: <?php //echo $total_area_techada_m2;?> </p>-->

            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 50%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: left; height: 20px;">Sotano(s):</td>
                        <td class="td" style ="text-align: right; height: 20px;"><?php echo $sotanos_m2;?> M2</td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 20px;">Semi sotano(s):</td>
                        <td class="td" style ="text-align: right; height: 20px;"><?php echo $semisotano_m2;?> M2</td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 20px;">Primer Piso o nivel:</td>
                        <td class="td" style ="text-align: right; height: 20px;"><?php echo $piso_nivel_m2;?> M2</td>
                    </tr>
                    <tr>
                        <td class="td" style ="text-align: left; height: 20px;">Otros Pisos o nivel:</td>
                        <td class="td" style ="text-align: right; height: 20px;"><?php echo $otro_piso_nivel_m2;?> M2</td>
                    </tr>
                    <tr style="border-top: 1px solid black;">
                        <td class="td" style="text-align: left; height: 20px;">Total Area Techada:</td>
                        <td class="td" style="text-align: right; height: 20px;"><?php echo $total_area_techada_m2;?> M2</td>
                    </tr>
                </tbody>
            </table>
            <p></p>
            <p></p>
            <table style="background-color:white !important;border-collapse:collapse;border-spacing:1px; width: 96%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <td class="td" style ="text-align: center; width: 32%; border-top: 1px solid black;">Gerencia Regional</td>
                        <td class="td" style ="text-align: center; width: 32%;"></td>
                        <td class="td" style ="text-align: center; width: 32%; border-top: 1px solid black;">Arquitecto Proyectista</td>
                    </tr>
                </tbody>
            </table>


           <!--  <p>Certificado para : Acreditar Habilitaci&oacute;n Profesional</p>
            
            <p>Validez por <?php //echo $datos[0]->dias_validez;?>  (<?php //echo $numeroEnLetras;?> ) d&iacute;as.</p>
            <p></p>
            <p></p>
            <p  style="text-align:right">Lima, <?php //echo $formattedDate;?></p> -->
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



