$html = '
<style>
table {
    font-size: 9px;
    width: 100%;
    border-spacing: 0;
    border: 0.4px solid #888;
}

th {
    background-color: #eaeaea;
    font-weight: bold;
    padding: 4px;
    text-align: center;
    border: 0.4px solid #888;
}

td {
    padding: 3px;
    border: 0.4px solid #888;
}
</style>

<body style="font-size: 10px; font-family: arial;border:1px solid #A4A4A4;padding:90px 10px 10px 10px">
<header>
    <table style="margin:0px;padding:0px;padding-bottom:10px">
        <tbody>
            <tr>
                <td colspan="1" class="td_left logo">
                    <img src="img/logo_encabezado.jpg" width="180" />
                </td>
                <td colspan="2" class="titulo_principal" style="padding:0px!important;margin:0px!important">
                    <table style="margin:0px!important;padding:0px!important;">
                        <tbody>
                            <tr>
                                <td align="center" colspan="11" class="titulo_principal">
                                    <h2><?php echo $titulo ?></h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:100px;text-align:right">Desde:</td>
                                <td style="width:60px;text-align:left"><?php echo $f_inicio ?></td>
                                <td style="width:60px;text-align:left"><?php echo $f_fin ?></td>
                                <td></td>
                                <td style="width:100px;text-align:right">TC:</td>
                                <td style="width:60px;text-align:left">3.84</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</header>

<table style="background-color:white !important;border-spacing: 0;" width="100%">
	<!--<table border="1" cellpadding="3" cellspacing="0" width="100%">-->
<tbody>

<!-- TITULOS -->
<tr>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="4%">Emisión</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="1%">TD</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="1%">Serie</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="1%">Número</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="2%">Cod. Trib.</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="10%">Destinatario</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="2%">Imp. Afecto</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="2%">Imp. Inafecto</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="2%">IGV</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="2%">Total</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="1%">Cond. Pago</td>
    <td style="border:1px solid #A4A4A4;font-weight:bold;background:#dbeddc" width="1%">Estado</td>
</tr>

<?php

$suma_imponible_afecto_boleta=0;
$suma_imponible_inafecto_boleta=0;
$suma_igv_total_boleta=0;
$suma_total_boleta=0;

$suma_imponible_afecto_factura=0;
$suma_imponible_inafecto_factura=0;
$suma_igv_total_factura=0;
$suma_total_factura=0;

$suma_imponible_afecto_nc=0;
$suma_imponible_inafecto_nc=0;
$suma_igv_total_nc=0;
$suma_total_nc=0;

?>

<!-- ================== BOLETAS ================== -->
<tr>
    <td colspan="12" style="border:1px solid #A4A4A4;font-weight:bold;background:#eef8ff">BOLETAS</td>
</tr>

<?php foreach($reporte_ventas as $d){ if($d->tipo=="BV"){ ?>
<tr>
    <td style="border:1px solid #A4A4A4"><?php echo $d->fecha ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->tipo ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->serie ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->numero ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->cod_tributario ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->destinatario ?></td>
    <td style="border:1px solid #A4A4A4; text-align:right !important;"><?php echo number_format($d->imp_afecto,2) ?></td>
    <td style="border:1px solid #A4A4A4" align="right"><?php echo number_format($d->imp_inafecto,2) ?></td>
    <td style="border:1px solid #A4A4A4" align="right"><?php echo number_format($d->impuesto,2) ?></td>
    <td style="border:1px solid #A4A4A4" align="right"><?php echo number_format($d->total,2) ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->forma_pago ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->estado_pago ?></td>
</tr>
<?php
$suma_imponible_afecto_boleta += $d->imp_afecto;
$suma_imponible_inafecto_boleta += $d->imp_inafecto;
$suma_igv_total_boleta += $d->impuesto;
$suma_total_boleta += $d->total;
}} ?>

<tr>
    <td colspan="6" align="right" style="border:1px solid #A4A4A4"><b>Total Boletas</b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_afecto_boleta,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_inafecto_boleta,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_igv_total_boleta,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_total_boleta,2) ?></b></td>
    <td colspan="2">&nbsp;</td>
</tr>

<!-- ================== FACTURAS ================== -->
<tr>
    <td colspan="12" style="border:1px solid #A4A4A4;font-weight:bold;background:#eef8ff">FACTURAS</td>
</tr>

<?php foreach($reporte_ventas as $d){ if($d->tipo=="FT"){ ?>
<tr>
    <td style="border:1px solid #A4A4A4"><?php echo $d->fecha ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->tipo ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->serie ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->numero ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->cod_tributario ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->destinatario ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->imp_afecto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->imp_inafecto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->impuesto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->total,2) ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->forma_pago ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->estado_pago ?></td>
</tr>
<?php
$suma_imponible_afecto_factura += $d->imp_afecto;
$suma_imponible_inafecto_factura += $d->imp_inafecto;
$suma_igv_total_factura += $d->impuesto;
$suma_total_factura += $d->total;
}} ?>

<tr>
    <td colspan="6" align="right" style="border:1px solid #A4A4A4"><b>Total Facturas</b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_afecto_factura,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_inafecto_factura,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_igv_total_factura,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_total_factura,2) ?></b></td>
    <td colspan="2"></td>
</tr>

<!-- ================== NOTAS DE CRÉDITO ================== -->
<tr>
    <td colspan="12" style="border:1px solid #A4A4A4;font-weight:bold;background:#eef8ff">NOTAS DE CRÉDITO</td>
</tr>

<?php foreach($reporte_ventas as $d){ if($d->tipo=="NC"){ ?>
<tr>
    <td style="border:1px solid #A4A4A4"><?php echo $d->fecha ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->tipo ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->serie ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->numero ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->cod_tributario ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->destinatario ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->imp_afecto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format($d->imp_inafecto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format(-1*$d->impuesto,2) ?></td>
    <td align="right" style="border:1px solid #A4A4A4"><?php echo number_format(-1*$d->total,2) ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->forma_pago ?></td>
    <td style="border:1px solid #A4A4A4"><?php echo $d->estado_pago ?></td>
</tr>
<?php
$suma_imponible_afecto_nc += $d->imp_afecto;
$suma_imponible_inafecto_nc += $d->imp_inafecto;
$suma_igv_total_nc += -1*$d->impuesto;
$suma_total_nc += -1*$d->total;
}} ?>

<tr>
    <td colspan="6" align="right" style="border:1px solid #A4A4A4"><b>Total Notas Crédito</b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_afecto_nc,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_imponible_inafecto_nc,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_igv_total_nc,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($suma_total_nc,2) ?></b></td>
    <td colspan="2"></td>
</tr>

<!-- ================== TOTALES GENERALES ================== -->
<?php
$total_afecto = $suma_imponible_afecto_boleta + $suma_imponible_afecto_factura + $suma_imponible_afecto_nc;
$total_inafecto = $suma_imponible_inafecto_boleta + $suma_imponible_inafecto_factura + $suma_imponible_inafecto_nc;
$total_igv = $suma_igv_total_boleta + $suma_igv_total_factura + $suma_igv_total_nc;
$total_general = $suma_total_boleta + $suma_total_factura + $suma_total_nc;
?>

<tr>
    <td colspan="6" align="right" style="border:1px solid #A4A4A4;background:#f1f1f1"><b>TOTALES GENERALES</b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($total_afecto,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($total_inafecto,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($total_igv,2) ?></b></td>
    <td align="right" style="border:1px solid #A4A4A4"><b><?php echo number_format($total_general,2) ?></b></td>
    <td colspan="2"></td>
</tr>

</tbody>
</table>
</body>