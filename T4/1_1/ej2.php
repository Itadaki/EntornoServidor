<!DOCTYPE html>
<!--
Autor = Diego Rodríguez Suárez-Bustillo
Fecha = 02-oct-2014
Licencia = default 
Version = 1.0
Descripcion = 
<!--

<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
  <head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
      <h1>Calcula científica</h1>
      <?php
      $a = array();
      $a['a'] = filter_input(INPUT_GET, "a");
      $a['b'] = filter_input(INPUT_GET, "b");
      $a['c'] = filter_input(INPUT_GET, "c");
      echo '<p>El resultado de la multiplicacion es:<br>';
      
      if (isset($a['a'])){
          echo $a['a'].' x ';
      }
      if (isset($a['b'])){
          echo $a['b'].' x ';
      }
      if (isset($a['c'])){
          echo $a['c'];
      }
      echo ' = <b>'.($a['a']?$a['a']:1)*(($a['b']?$a['b']:1))*($a['c']?$a['c']:1).'</b></p>';
      
      echo '<p>El resultado de la suma es:<br>';
      
      if (isset($a['a'])){
          echo $a['a'].' + ';
      }
      if (isset($a['b'])){
          echo $a['b'].' + ';
      }
      if (isset($a['c'])){
          echo $a['c'];
      }
      echo ' = <b>'.($a['a']?$a['a']:0)+(($a['b']?$a['b']:0))+($a['c']?$a['c']:0).'</b></p>';
      
      $mayor=0;
      $menor=$a['a'];
      foreach ($a as $value){
          if ($value > $mayor){
              $mayor=$value;
          }
      }
      foreach ($a as $value){
          if ($value < $menor){
              $menor=$value;
          }
      }
      echo "<p>El número mayor es: <b>$mayor</b><br>El número menor es: <b>$menor</b></p>"
      ?>
  </body>
</html>
