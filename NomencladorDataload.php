<?php

$lines_of_file = file("NOMARCHIVO.TXT");

$file_content = file_get_contents("NOMARCHIVO.TXT");
$array = explode("--", $file_content);

$uno =explode(";", $array[0]);
$i=0;

$link = mysql_connect('localhost', 'entityst_user', 'JJlab2017')
    or die('No se pudo conectar: ' . mysql_error());

//echo 'Connected successfully';
mysql_select_db('entityst_jjlab') or die('No se pudo seleccionar la base de datos');

foreach ($array as $valor) {
    $actual =explode(";", $valor);
    
    echo "codigo : " . $actual[0] . '<br/>';
    echo "u gastos: " . $actual[2] . '<br/>';
    echo "u honorarios: " . $actual[3];

    $query= 'INSERT INTO Nomencladores
            (Area,
             Cantidad,
             Codigo,
             CodigoFABA,
             Complejidad, 
             CreadoFecha,
             CreadoPor,
             EstaBorrado,
             IdMuestra,
             INOS,        
             INOSReducido,
             Lista,
             NBUCodigo,
             NBUFrecuencia,
             Nivel,       
             Nombre,
             NoNomenclada,
             Proceso,
             RIA,
             TiempoRealizacion, 
             UGastos,
             UHonorarios,
             _677)'. 
            'VALUES (' 
                .'\''
                . $actual[8]
                .'\''
                . ','  // Fin Area        
                .'\''
                .'\''
                . ',' // Fin cantidad
                .'\''
                . trim($actual[0])
                .'\''
                . ',' // Fin Codigo
                .'\''
                . $actual[19]
                .'\'' 
                . ',' // Fin Codigo FABA
                .'\''
                .'\''
                . ',' // Fin Complejidad
                .'\''
                . date('Y-m-d H:i:s')
                .'\'' 
                . ',' //Fin Fecha Creado
                .'\'' 
                .'dataload'
                .'\'' 
                . ',' //Fin Creado Por
                .'\'' 
                . '0'
                .'\''  // Fin Esta borrado
                . ','
                .'\'' 
                . $actual[4]
                .'\'' 
                . ','
                .'\'' 
                . $actual[6]
                .'\'' 
                . ','
                .'\'' 
                . $actual[9]
                .'\'' 
                . ','
                .'\'' 
                . $actual[18]
                .'\'' 
                . ','
                .'\'' 
                . $actual[23]
                .'\'' 
                . ','
                .'\'' 
                . $actual[28]
                .'\'' 
                . ','
                .'\'' 
                . $actual[20]
                .'\'' 
                . ','
                .'\'' 
                . $actual[1]
                .'\'' 
                . ','
                .'\'' 
                . $actual[10]
                .'\'' 
                . ','
                .'\'' 
                . $actual[16]
                .'\'' 
                . ','
                .'\'' 
                . $actual[7]
                .'\'' 
                . ','
                .'\'' 
                . $actual[5]
                .'\'' 
                . ','
                .'\'' 
                . $actual[2]
                .'\'' 
                . ','
                .'\'' 
                . $actual[3]
                .'\'' 
                . ','
                .'\'' 
                . $actual[14]
                .'\''
                .')'; 
    
    echo '<br>';echo '<br>';

    //$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $i++;
}
?>