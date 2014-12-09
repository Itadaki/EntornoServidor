<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

for ($i = 1; $i <= 4; $i++) {
    echo "<br>$i)= ";
    $suma = 0;
    for ($j = $i; $j >= 0; $j--) {
        $suma+=$j;
        if ($j != 0) {
            echo "$j + ";
        } else {
            echo "$j";
        }
    }
    echo " = <b>$suma</b>";
}