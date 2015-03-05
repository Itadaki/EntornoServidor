<?php

function addTable($table) {
    global $colFrom;
    $colFrom[] = $table;
}

function addWhere($where) {
    global $colWhere;
    $colWhere[] = $where;
}

function setFuncion($func) {
    global $funcion;
    $funcion = $func;
}

function addSelect($columna) {
    global $colSelect;
    $colSelect[] = $columna;
}

function addValue($valor) {
    global $colValue;
    $colValue[] = $valor;
}
###DADA###
function addUpdate($valor) {
    global $colUpdate;
    $colUpdate[] = $valor . "= ?";
}

function generar() {
    global $colFrom;
    global $colWhere;
    global $funcion;
    global $colSelect;
    global $colValue;
    global $colUpdate;
    $select = implode(',', array_unique($colSelect));
    $from = implode(',', array_unique($colFrom));
    $where = implode(' AND ', array_unique($colWhere));
    $values = implode(',', $colValue);
    $update = implode(',', $colUpdate);
    $funcion = $funcion;
    $sql = $funcion . ' ';
    if ($funcion == 'insert') {
        $sql.='INTO ' . $from . '(' . $select . ') values (' . $values . ')';
    } elseif ($funcion == 'update') {
        $sql.= $from . ' SET ' . $update;
        if (!empty($colWhere)) {
            $sql.=' WHERE ' . $where;
        }
    } else {
        $sql = $funcion . ' ' . $select . ' FROM ' . $from;
        if (!empty($colWhere)) {
            $sql.=' WHERE ' . $where;
        }
    }
    return $sql;
}
