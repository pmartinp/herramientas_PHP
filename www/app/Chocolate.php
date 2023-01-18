<?php

declare(strict_types=1);

namespace www\app;

include_once("./autoload.php");
//include_once("Dulce.php");

class Chocolate extends Dulce
{

    public function __construct(
        string $nombre,
        int $numero,
        float $precio,
        private float $porcentajeCacao,
        private float $peso
    ) {
        parent::__construct($nombre, $numero, $precio);
    }

    /**
     * Get the value of porcentajeCacao
     */
    public function getPorcentajeCacao()
    {
        return $this->porcentajeCacao;
    }
    /**
     * Get the value of peso
     */
    public function getPeso()
    {
        return $this->peso;
    }

    // Muestra un resumen de los atributos de la clase
    public function muestraResumen()
    {
        parent::muestraResumen();
        echo "<br>Porcentaje de cacao: " . $this->getPorcentajeCacao() . "%"."<br>Peso: " . $this->getPeso()."g";
    }
}
