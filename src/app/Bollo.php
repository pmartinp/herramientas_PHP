<?php

declare(strict_types=1);

namespace src\app;

include_once("./autoload.php");
//include_once("Dulce.php");

class Bollo extends Dulce
{

    public function __construct(
        string $nombre,
        int $numero,
        float $precio,
        private string $relleno
    ) {
        parent::__construct($nombre, $numero, $precio);
    }

    /**
     * Get the value of relleno
     */
    public function getRelleno()
    {
        return $this->relleno;
    }

    // Muestra un resumen de los atributos de la clase
    public function muestraResumen()
    {
        parent::muestraResumen();
        echo "<br>Relleno: " . $this->getRelleno();
    }
}
