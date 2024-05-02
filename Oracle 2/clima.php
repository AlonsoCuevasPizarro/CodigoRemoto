<?php
$url = 'https://climatologia.meteochile.gob.cl/application/servicios/getDatosRecientesRedEma?usuario=correo@correo.cl&token=apiKey_personal';
$ch = curl_init();
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
    CURLOPT_URL => $url
);
curl_setopt_array($ch, $options);
$output = curl_exec($ch);
if (!$output) {
    echo "Curl Error : " . curl_error($ch);
} else {
    $data = json_decode($output, true);
    if (isset($data['datosEstaciones'])) {
        $estaciones = $data['datosEstaciones'];
    } else {
        echo "No se encontraron datos disponibles.";
        exit;
    }
}
