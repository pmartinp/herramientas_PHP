<?php
// Archivo para probar métodos de la clase videoclub
include __DIR__."/vendor/autoload.php";
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

echo $ps->listarProductos();
//voy a crear algunos socios
$ps->incluirCliente("Amancio Ortega");
$ps->incluirCliente("Pablo Picasso", 6);

echo $ps->listarClientes();

// para poder probarlo haría falta cambiar a "public" la propiedad $productos de la clase "Pasteleria"
$ps->comprarClienteProducto(0, 0)->comprarClienteProducto(1, 2)->comprarClienteProducto(1, 2);

echo $ps->listarClientes();

echo $ps->getClientes()[0]->listarPedidos();

$ps->getClientes()[0]->valorar($ps->getProductos()[5], "Está de arte");