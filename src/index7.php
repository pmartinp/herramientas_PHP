<?php
// Archivo para probar el funcionamiento de login.php
include "autoload.php";
use src\app\Pasteleria;

$ps = new Pasteleria("Severo 8A");

//voy a incluir unos cuantos soportes de prueba
$ps->incluirTarta("Tarta la aweli", 19.99, 3, ["chocolate", "vainilla", "natilla"], 5);
$ps->incluirTarta("Tarta de queso", 12.30, 2, ["queso", "fresa"], 3);
$ps->incluirChocolate("Negro", 8.25, 95, 500);
$ps->incluirChocolate("Blanco", 3.0, 0.5, 150);
$ps->incluirBollo("Manolito", 4.83, "Pistacho");
$ps->incluirBollo("Suso", 1.5, "Crema");

//voy a crear algunos socios
$ps->incluirCliente("Amancio Ortega");
$ps->incluirCliente("Pablo Picasso", 2);
