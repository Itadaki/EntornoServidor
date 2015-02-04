<?php

//$id = fopen('http://myanimelist.net/malappinfo.php?u=itadaki&status=all&type=anime', 'r');
$id = fopen('malappinfo.xml', 'r');
$xml = '';
while ($linea = fgets($id)){
    $xml.= $linea;
}
header('Content-Type: text/xml');
echo $xml;