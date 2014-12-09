<?php

function mayor() {
    $args = func_get_args();
    $mayor = 0;
    for ($i = 0; $i < func_num_args(); $i++) {
        if ($args[$i] > $mayor) {
            $mayor = $args[$i];
        }
    }
    return $mayor;
}
