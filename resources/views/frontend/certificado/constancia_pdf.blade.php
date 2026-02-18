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
        <div style="text-align: center; height: 100px; position: relative;">
            <img width="196px" height="58px" style="margin-top:50px;" src="img/logo_cap.jpg">
        <div>
    <h2 style="text-align:center">CONSTANCIA</h2>
    <p style="text-align:center">  EL COLEGIO DE ARQUITECTOS DEL PER&Uacute; - REGIONAL LIMA, </p>
    <p style="text-align:left">  Deja constancia que: </p>
        <div class="contenido">
            <h3 class="contenido_encabezado" > <b> ARQ. <?php echo $datos[0]->agremiado;?> </b></h3>
            <h3 class="contenido_encabezado_cap"> CAP <?php echo $datos[0]->numero_cap;?> </h3>
            <p class="contenido_cuerpo" >Se encuentra <?php echo $inscripcion;?> desde el <?php echo $fecha_inscripcion_detallada;?> en los registros de 
                            nuestra Institución como Miembro de la Orden con el n&uacute;mero de CAP  <?php echo $datos[0]->numero_cap;?> y
                            n&uacute;mero de registro <?php echo $datos[0]->numero_regional;?> en la Regional Lima y ha cancelado sus cuotas
                            institucionales de enero a diciembre de <?php echo $anio_certificado?>.</p>

            <p class="contenido_cuerpo">Por lo tanto, se encuentra <?php echo $colegia;?> y <?php echo $habilita_mayus;?> para ejercer la profesi&oacute;n
                hasta el 31 de diciembre del <?php echo $anio_certificado?></p>
            <p></p>
            
            <p class="contenido_cuerpo">Extendemos la presente constancia, para los fines que estime pertinentes.</p>
            
            <p></p>
            <p class="contenido_cuerpo" style="text-align: right !important;">Lima, <?php echo $fecha_detallada;?></p>
           
            <div style="text-align: center; position: relative; height: 100px;">
                <img width="200px" height="80px" src="img/FIRMA-DECANO.png">
            <div>
            
            <p class="contenido_cuerpo" style="text-align: center !important;margin-bottom: 50px; ">FIRMA Y SELLO DEL DECANO REGIONAL</p>
            <br></br>
            <p class="info_pie" style="margin-bottom: 0; margin-top: 0;"> Av. San Felipe 999 - Jesús María 15072. Teléfono (01) 6271200 / 6271201, e-mail:</p>
            <p class="info_pie" style="margin-bottom: 0; margin-top: 0;"><a href="mailto:mesadepartesvirtual@limacap.org">mesadepartesvirtual@limacap.org</a></p>
            <p class="info_pie" style="margin-bottom: 0; margin-top: 0;"><a href="https://www.limacap.org" target="_blank">www.limacap.org</a></p>
        </div>
        <div class="detalle_pie_pagina">
            <p style="margin: 0;">“Carta N°0547-2024-GN-CAP…”: “…Directiva Nacional para la Emisi&oacute;n de Constancia y Certificado &Uacute;nico de Habilitaci&oacute;n</p>
            <p style="margin: 0;">Urbana Profesional, aprobado en la Sesi&oacute;n N°08-2024 de Consejo Nacional de fecha 22 de mayo 2024…”</p>
            <p style="margin: 0;">“Carta N°0755-2024-GN_CAP…”</p>
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



