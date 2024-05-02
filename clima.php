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
    $data = json_decode($output, true); // Decodificar el JSON en un array asociativo

    // Verificar si se recibieron datos
    if (isset($data['datosEstaciones'])) {
        $estaciones = $data['datosEstaciones'];
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Datos Recientes Red EMA</title>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th,
                td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
            </style>
        </head>

        <body>
            <h1>Datos Recientes Red EMA</h1>
            <table>
                <thead>
                    <tr>
                        <th>Estación</th>
                        <th>Temperatura (°C)</th>
                        <th>Humedad Relativa (%)</th>
                        <th>Presión (hPas)</th>
                        <!-- Agrega más columnas según los datos que quieras mostrar -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estaciones as $estacion) : ?>
                        <?php foreach ($estacion['datos'] as $dato) : ?>
                            <tr>
                                <td><?php echo $estacion['estacion']['nombreEstacion']; ?></td>
                                <td><?php echo $dato['temperatura']; ?></td>
                                <td><?php echo $dato['humedadRelativa']; ?></td>
                                <td><?php echo $dato['presionEstacion']; ?></td>
                                <!-- Agrega más celdas según los datos que quieras mostrar -->
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </body>

        </html>
<?php
    } else {
        echo "No se encontraron datos disponibles.";
    }
}
