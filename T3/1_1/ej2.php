<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Sentencia <i>if</i></h1>
        <?php
        $day = date("D");
        $dia;
        switch ($day){
            case "Sun":
                $dia="Domingo";
                break;
            case "Mon":
                $dia="Lunes";
                break;
            case "Tue":
                $dia="Martes";
                break;
            case "Whe":
                $dia="Miércoles";
                break;
            case "Thu":
                $dia="Jueves";
                break;
            case "Fri":
                $dia="Viernes";
                break;
            case "Sat":
                $dia="Sábado";
                break;
        }
        echo "Hoy es <b>$dia</b>";
        ?>
    </body>
</html>
