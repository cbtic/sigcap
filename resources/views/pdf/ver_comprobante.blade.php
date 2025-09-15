<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CAP</title>
        <link rel="stylesheet" type="text/css" href="css/pdf.css"  />
        <style>
            body {
				font-family: DejaVu Sans, sans-serif;
				font-size: 13px;
				margin: 0px;
			}
			.header {
				width: 100%;
				margin-bottom: 10px;
			}
			.header td {
				vertical-align: top;
			}
			.empresa-datos {
				font-size: 13px;
				text-align: left;
			}
			.ruc-box {
				border: 2px solid #000;
				padding: 10px;
				text-align: center;
				font-weight: bold;
				font-size: 17px;
			}
			.title {
				margin-top: 10px;
				font-size: 14px;
				font-weight: bold;
				text-align: left;
			}
			.datos-cliente {
				width: 100%;
				margin-top: 10px;
				font-size: 13px;
			}
			.datos-cliente td {
				padding: 3px 5px;
			}
			table.detalle {
				width: 100%;
				border-collapse: collapse;
				margin-top: 10px;
			}
			table.detalle th, table.detalle td {
				border: 1px solid #000;
				padding: 4px;
				text-align: center;
				font-size: 12px;
			}
			table.totales {
				width: 40%;
				float: right;
				border-collapse: collapse;
				margin-top: 10px;
			}
			table.totales td {
				padding: 3px 5px;
				font-size: 12px;
			}
			.monto-letras {
				margin-top: 10px;
				font-style: italic;
			}
			.footer {
				margin-top: 40px;
				font-size: 11px;
			}
			.qr {
				margin-top: 20px;
			}

        </style>
    </head>
	
    <body style="font-size: 11px; font-family: arial;padding:10px 0px 10px 0px">
		
		<table class="header">
        <tr>
            <td width="25%">
                <img src="{{ public_path('img/logo_encabezado.jpg') }}" alt="Logo" height="80">
            </td>
            <td width="35%" class="empresa-datos">
                <!--<strong>REGIONAL LIMA</strong><br>-->
                Av. San Felipe 999 <br>
                Jesús María, Lima, Lima <br>
                Teléfono: 627-1200 <br>
                E-mail: lima@limacap.org <br>
                www.limacap.org
            </td>
            <td width="40%">
                <div class="ruc-box">
                    RUC N° 20172977911 <br>
                    BOLETA DE VENTA ELECTRÓNICA <br>
                    {{ $comprobante->serie }}-{{ $comprobante->numero }}
                </div>
            </td>
        </tr>
    </table>

    <div class="title">
        COLEGIO DE ARQUITECTOS DEL PERU - REGIONAL LIMA - Teléfono: (01) 6271200
    </div>
    <div>
        AV. SAN FELIPE NRO. 999 LIMA - LIMA - JESUS MARIA
    </div>

    <table class="datos-cliente">
        <tr>
            <td><strong>SEÑOR (ES)</strong>: {{ $comprobante->destinatario }}</td>
            <td><strong>F. EMISIÓN</strong>: {{ date('d-m-Y',strtotime($comprobante->fecha)) }}</td>
        </tr>
        <tr>
            <td><strong>DNI/RUC</strong>: {{ $comprobante->cod_tributario }}</td>
            <td><strong>MONEDA</strong>: PEN - SOLES</td>
        </tr>
        <tr>
            <td><strong>DIRECCIÓN</strong>: {{ $comprobante->direccion }}</td>
            <td><strong>MEDIO DE PAGO</strong>: {{ $comprobante->medio_pago }}</td>
        </tr>
    </table>

    <table class="detalle">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th>CANT.</th>
                <th>UM</th>
                <th>V. UNITARIO</th>
                <th>P. UNITARIO</th>
                <th>DSCTO</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comprobante_detalles as $item)
            <tr>
                <td>{{ $item->item }}</td>
                <td style="text-align:left">{{ $item->descripcion }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->unidad }}</td>
                <td>{{ number_format($item->pu,2) }}</td>
                <td>{{ number_format($item->pu,2) }}</td>
                <td>{{ number_format($item->descuento,2) }}</td>
                <td>{{ number_format($item->importe,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="monto-letras">
        SON: {{ $comprobante->letras }}
    </div>

    <table class="totales">
        <tr><td>OP. GRAVADAS</td><td>S/ {{ number_format($comprobante->op_gravadas,2) }}</td></tr>
        <tr><td>OP. INAFECTA</td><td>S/ {{ number_format($comprobante->total,2) }}</td></tr>
        <tr><td>OP. EXONERADA</td><td>S/ {{ number_format($comprobante->op_exonerada,2) }}</td></tr>
        <tr><td>OP. GRATUITA</td><td>S/ {{ number_format($comprobante->op_gratuita,2) }}</td></tr>
        <tr><td>IGV</td><td>S/ {{ number_format($comprobante->igv,2) }}</td></tr>
        <tr><td><strong>IMPORTE TOTAL</strong></td><td><strong>S/ {{ number_format($comprobante->total,2) }}</strong></td></tr>
        <tr><td>PERCEPCIÓN</td><td>S/ {{ number_format($comprobante->percepcion,2) }}</td></tr>
        <tr><td><strong>TOTAL A COBRAR</strong></td><td><strong>S/ {{ number_format($comprobante->total,2) }}</strong></td></tr>
    </table>
		
    </body>
</html>