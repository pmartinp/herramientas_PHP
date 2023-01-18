<?php

declare(strict_types=1);

namespace src\app;
include_once("./autoload.php");
//include_once("Resumible.php");

abstract class Dulce implements Resumible
{

        private const IVA = 21;

        public function __construct(
                public string $nombre,
                protected int $numero,
                private float $precio,
        ) {
        }


        /**
         * Get the value of precio
         */
        public function getPrecio()
        {
                return $this->precio;
        }
        /**
         * Get the value of precio with IVA
         */
        public function getPrecioConIva()
        {
                return $this->precio * (1+self::IVA / 100);
        }
        /**
         * Get the value of numero
         */
        public function getNumero()
        {
                return $this->numero;
        }

        // Muestra un resumen de los atributos de la clase
        public function muestraResumen()
        {
                echo "<br>Nombre: " . $this->nombre . "<br>Número: " . $this->getNumero() . "<br>Precio: " . $this->getPrecio() . "€" . "<br>Precio con IVA: " . $this->getPrecioConIva() . "€";
        }
}


/* Al hacer esta clase abstracta imposibilitamos su instanciación, 
de esta manera solo se prodrán crear objetos de sus clases "hijas" o "concretas".
Es por eso que si ejecutásemos el script "index1.php" saltaría el error
"Cannot instantiate abstract class Soporte".
*/