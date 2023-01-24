<?php

namespace src\tests;
use PHPUnit\Framework\TestCase;
use src\app\Pasteleria;

include_once("./autoload.php");

class PasteleriaTest extends TestCase
{
    public function testincluirProductos(){
        $ps = new Pasteleria("Severo 8A");

        $ps->incluirTarta("Tarta la aweli", 19.99, 3, ["chocolate", "vainilla", "natilla"], 5);
        $ps->incluirTarta("Tarta de queso", 12.30, 2, ["queso", "fresa"], 3);
        $ps->incluirChocolate("Negro", 8.25, 95, 500);
        $ps->incluirChocolate("Blanco", 3.0, 0.5, 150);
        $ps->incluirBollo("Manolito", 4.83, "Pistacho");
        $ps->incluirBollo("Suso", 1.5, "Crema");
        
        $this->assertSame(6, $ps->getNumProductos());
        $this->assertNotSame(20, $ps->getNumProductos());        
    }

    public function testComprar(){
        $ps = new Pasteleria("Severo 8A");

        $ps->incluirTarta("Tarta la aweli", 19.99, 3, ["chocolate", "vainilla", "natilla"], 5);

        $ps->incluirCliente("Amancio Ortega");
        $ps->comprarClienteProducto(0, 0);
        
        $this->assertSame("Tarta la aweli", $ps->getClientes()[0]->getDulcesComprados()[0]->nombre);       
    }
}