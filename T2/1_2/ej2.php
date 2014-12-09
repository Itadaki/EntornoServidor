<!DOCTYPE html>
<!--
15-sep-2014 - 11:02:08
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            tr{
               alignment-adjust: right; 
            }
            td.n{
                background-color: yellow;
            }
        </style>
    </head>
    <body>
        <TABLE BORDER="1" CELLPADDING="2" CELLSPACING="2">
            <TR>
            <TD class="n">Decimal Positivo</TD>
            <TD>
                <?php
                $num = 502; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
            
            <TR>
            <TD class="n">Decimal Negativo</TD>
            <TD>
                <?php
                $num = -502; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
            
            <TR>
            <TD class="n">Decimal Octal</TD>
            <TD>
                <?php
                $num = 0512; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
            
            <TR>
            <TD class="n">Decimal Hexadecimal</TD>
            <TD>
                <?php
                $num = 0x12; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
            
            <TR>
            <TD class="n">Estandar</TD>
            <TD>
                <?php
                $num = 2.589; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
            
            <TR>
            <TD class="n">Cientifico</TD>
            <TD>
                <?php
                $num = 1.5e2; //número entero decimal
                echo $num; //mostramos el valor de $num
                ?>
            </TD>
            </TR>
        </table>
    </body>
</html>
