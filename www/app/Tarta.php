<?php

declare(strict_types=1);

namespace www\app;

include_once("./autoload.php");
//include_once("Dulce.php");

class Tarta extends Dulce
{

    public function __construct(
        string $nombre,
        int $numero,
        float $precio,
        private int $numPisos,
        private $rellenos = [],
        private int $maxNumComensales,
        private int $minNumComensales = 2
    ) {
        parent::__construct($nombre, $numero, $precio);
    }

    /**
     * Get the value of numPisos
     */
    public function getNumPisos()
    {
        return $this->numPisos;
    }
    /**
     * Get the value of minNumJugadores
     */
    public function getMinNumComensales()
    {
        return $this->minNumComensales;
    }
    /**
     * Get the value of maxNumJugadores
     */
    public function getMaxNumComensales()
    {
        return $this->maxNumComensales;
    }
    // Muestra los jugadores mínimos y máximo
    public function muestraComensalesPosibles()
    {
        if ($this->getMinNumComensales() == 1 && $this->getMaxNumComensales() == 1) {
            echo "<br>Para un comensal";
        } else if ($this->getMinNumComensales() == $this->getMaxNumComensales() && $this->getMaxNumComensales() > 1) {
            echo "<br>Para " . $this->getMinNumComensales() . " comensales";
        } else {
            echo "<br>De " . $this->getMinNumComensales() . " a " . $this->getMaxNumComensales() . " comensales";
        }
    }

    // Muestra un resumen de los atributos de la clase
    public function muestraResumen()
    {
        parent::muestraResumen();
        echo "<br>Número de pisos: " . $this->getNumPisos();
        $this->muestraComensalesPosibles();
    }
}
