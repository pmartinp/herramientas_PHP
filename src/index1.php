<?php

include "autoload.php";
use src\app\Bollo;

/*
$soporte1 = new Soporte("Tenet", 22, 3);
echo "<strong>" . $soporte1->titulo . "</strong>"; 
echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->muestraResumen();
*/

$bollo = new Bollo("Manolito", 23, 3.5, "chocolate"); 
echo "<br><strong>" . $bollo->nombre . "</strong>"; 
echo "<br>Precio: " . $bollo->getPrecio() . " €"; 
echo "<br>Precio IVA incluido: " . $bollo->getPrecioConIva() . " €";
$bollo->muestraResumen();