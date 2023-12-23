<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://test.easyfact.tk/see/rest/01",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS =>"{\n    \"items\": [\n        {\n            \"ordenItem\": \"1\",\n            \"adicionales\": [],\n            \"cantidadItem\": \"1\",\n            \"descuentoItem\": \"0.00\",\n            \"importeIGVItem\": \"15.25\",\n            \"montoTotalItem\": \"100.00\",\n            \"valorVentaItem\": \"84.75\",\n            \"descripcionItem\": \"ALQUILER DE ESPACIOS\",\n            \"unidadMedidaItem\": \"ZZ\",\n            \"codigoProductoItem\": \"001\",\n            \"valorUnitarioSinIgv\": \"84.7457627119\",\n            \"precioUnitarioConIgv\": \"100.0000000000\",\n            \"unidadMedidaComercial\": \"SERV\",\n            \"codigoAfectacionIGVItem\": \"10\",\n            \"porcentajeDescuentoItem\": \"0.00\",\n            \"codTipoPrecioVtaUnitarioItem\": \"01\"\n        },\n        {\n            \"ordenItem\": \"2\",\n            \"adicionales\": [],\n            \"cantidadItem\": \"1\",\n            \"descuentoItem\": \"0.00\",\n            \"importeIGVItem\": \"7.63\",\n            \"montoTotalItem\": \"50.00\",\n            \"valorVentaItem\": \"42.37\",\n            \"descripcionItem\": \"TRANSBORDO\",\n            \"unidadMedidaItem\": \"ZZ\",\n            \"codigoProductoItem\": \"002\",\n            \"valorUnitarioSinIgv\": \"42.3728813559\",\n            \"precioUnitarioConIgv\": \"50.0000000000\",\n            \"unidadMedidaComercial\": \"SERV\",\n            \"codigoAfectacionIGVItem\": \"10\",\n            \"porcentajeDescuentoItem\": \"0.00\",\n            \"codTipoPrecioVtaUnitarioItem\": \"01\"\n        }\n    ],\n\n    \"anulado\": false,\n    \"declare\": \"0\",\n    \"version\": \"2.1\",\n    \"adjuntos\": [],\n    \"anticipos\": [],\n    \"esFicticio\": false,\n    \"keepNumber\": \"false\",\n    \"tipoCorreo\": \"1\",\n    \"tipoMoneda\": \"PEN\",\n    \"adicionales\": [],\n    \"horaEmision\": \"12:12:04\",\n    \"serieNumero\": \"F001-000007\",\n    \"fechaEmision\": \"2020-03-27\",\n    \"importeTotal\": \"150.00\",\n    \"notification\": \"1\",\n    \"sumatoriaIGV\": \"22.88\",\n    \"sumatoriaISC\": \"0.00\",\n    \"ubigeoEmisor\": \"070101\",\n    \"montoEnLetras\": \"CIENTO CINCUENTA Y 00/100\",\n    \"tipoDocumento\": \"01\",\n    \"correoReceptor\": \"frimacc@gmail.com\",\n    \"distritoEmisor\": \"CALLAO\",\n    \"esContingencia\": false,\n    \"telefonoEmisor\": \"988481939\",\n    \"totalAnticipos\": \"0.00\",\n    \"direccionEmisor\": \"AV. NESTOR GAMBETA NRO. 6311 CARRETERA A VENTANILLA (ALTURA KM 5.200 CARRETERA VENTANILLA) \",\n    \"provinciaEmisor\": \"CALLAO\",\n    \"totalDescuentos\": \"0.00\",\n    \"totalOPGravadas\": \"127.12\",\n    \"codigoPaisEmisor\": \"PE\",\n    \"totalOPGratuitas\": \"0.00\",\n    \"docAfectadoFisico\": false,\n    \"importeTotalVenta\": \"150.00\",\n    \"razonSocialEmisor\": \"CAP - Lima SRLTDA\",\n    \"totalOPExoneradas\": \"0.00\",\n    \"totalOPNoGravadas\": \"0.00\",\n    \"codigoPaisReceptor\": \"PE\",\n    \"departamentoEmisor\": \"CALLAO\",\n    \"descuentosGlobales\": \"0.00\",\n    \"codigoTipoOperacion\": \"0101\",\n    \"razonSocialReceptor\": \"Freddy Rimac Coral\",\n    \"nombreComercialEmisor\": \"CAP - Lima\",\n    \"tipoDocIdentidadEmisor\": \"6\",\n    \"sumatoriaImpuestoBolsas\": \"0.00\",\n    \"numeroDocIdentidadEmisor\": \"20160453908\",\n    \"tipoDocIdentidadReceptor\": \"6\",\n    \"numeroDocIdentidadReceptor\": \"10040834643\"\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Basic c2ZlQGZlbG1vOjEyMzQ1Ng=="
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
