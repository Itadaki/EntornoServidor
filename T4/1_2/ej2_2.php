<?php

$day = date("D");
$img = array(
    "Sun" => "img.png",
    "Mon" => "img.gif",
    "Tue" => "img.png",
    "Wen" => "img.gif",
    "Thu" => "img.png",
    "Fri" => "img.gif",
    "Sat" => "img.png"
);

echo '<img src="'.$img[$day].'" />';
