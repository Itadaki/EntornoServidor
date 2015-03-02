<?php
$a[1][1]="SMR";
$a[2][1]="DAM";
$a[2][2]="DAW";
$a[2][3]="ASIR";
$a[3][1]="SISTEMAS";
$a[3][2]="GESTIÓN";

$response = $_POST['titulacion'];
$doc = json_decode($response,true);
$titulaciones=$doc['titulaciones'];

header('Content-Type: text/xml');
$xml="<respuesta>";
foreach ($titulaciones as $i) {
    $xml=$xml."<titulacion>";
    $especialidades=$a[$i];
    foreach ($especialidades as $j) {
        $xml=$xml."<especialidad>".$j."</especialidad>";
       
    }
    $xml=$xml."</titulacion>";
}
$xml=$xml."</respuesta>";
echo $xml;
?>