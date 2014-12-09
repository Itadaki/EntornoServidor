<?php

function toEuro() {
    $n = func_get_arg(0);
    return sprintf("%02.2f", $n / 166.386);
}

function toDolar() {
    $n = func_get_arg(0);
    return sprintf("%02.2f", $n / 131.658);
}

function toYen() {
    $n = func_get_arg(0);
    return sprintf("%02.2f", $n / 1.056);
}

function sumar() {
    $args = func_get_args();
    $suma = 0;
    for ($i = 0; $i < count($args); $i++) {
        if (is_numeric($args[$i])) {
            $suma += $args[$i];
        }
    }
    return $suma;
}

function restar() {
    $args = func_get_args();
    $resta = func_get_arg(0);
    for ($i = 1; $i < count($args); $i++) {
        if (is_numeric($args[$i])) {
            $resta -= $args[$i];
        }
    }
    return $resta;
}

function multiplicar() {
    $args = func_get_args();
    $multi = 1;
    for ($i = 0; $i < count($args); $i++) {
        if (is_numeric($args[$i])) {
            $multi *= $args[$i];
        }
    }
    return $multi;
}

function dividir() {
    $args = func_get_args();
    $divi = 1;
    for ($i = 0; $i < count($args); $i++) {
        if (is_numeric($args[$i])) {
            $divi /= $divi;
        }
    }
    return $divi;
}
