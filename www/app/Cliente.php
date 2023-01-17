<?php

declare(strict_types=1);

namespace herramientas_PHP\www\app;

use herramientas_PHP\www\util\CupoSuperadoException;
use herramientas_PHP\www\util\SoporteNoEncontradoException;
use herramientas_PHP\www\util\SoporteYaAlquiladoException;

class Cliente
{

    private $dulcesComprados = [];
    private int $numDulcesComprados = 0;
    public string $user;

    public function __construct(
        public string $nombre,
        private int $numero,
        private int $numPedidosEfectuados = 0,
        private string $password = "usuario"
    ) {
        $this->setUser();
    }



    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }
    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }
    /**
     * Get the value of numPedidosEfectuados
     */
    public function getNumPedidosEfectuados()
    {
        return $this->numPedidosEfectuados;
    }
    /**
     * Get the value of dulcesComprados
     */ 
    public function getDulcesComprados()
    {
        return $this->dulcesComprados;
    }
    /**
     * Get the value of numDulcesComprados
     */ 
    public function getNumDulcesComprados()
    {
        return $this->numDulcesComprados;
    }
    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser()
    {
        $this->user = $this->nombre . $this->getNumero();

        return $this;
    }
    /**
     * Set the value of numSoportesAlquilados
     *
     * @return  self
     */
    public function setNumSoportesAlquilados($numSoportesAlquilados)
    {
        if ($numSoportesAlquilados < 0 || $numSoportesAlquilados > $this->getMaxAlquilerConcurrente()) {
            throw new CupoSuperadoException();
        } else {
            $this->numSoportesAlquilados = $numSoportesAlquilados;
            return $this;
        }
    }

    // comprueba si es posible alquilar un soporte y si lo es lo añade al array soportesAlquilados (lo alquila)
    public function comprar(Dulce $d): bool
    {
        if (!$this->tieneAlquilado($s)) {
            $this->setNumSoportesAlquilados($this->numSoportesAlquilados + 1);
            $this->soportesAlquilados[] = $s;
            echo "<br>Alquiler realizado con éxito";

            $s->alquilado = true;
            return $this;
        } else {
            throw new SoporteYaAlquiladoException();
        }
    }

    // comprueba si el parámetro $s está alquilado o no
    public function tieneAlquilado(Soporte $s): bool
    {
        return in_array($s, $this->soportesAlquilados);
    }

    //
    public function devolver(Soporte $s)
    {
        echo "<br>";
        if ($this->tieneAlquilado($s)) {
            unset($this->soportesAlquilados[array_search($s, $this->soportesAlquilados)]);
            $this->setNumSoportesAlquilados($this->numSoportesAlquilados--);
            echo "Soporte devuelto con éxito";
        } else {
            echo "El soporte no estaba alquilado";
        }
        return $this;
    }

    public function listaDeDulces()
    {
        echo "<br>";
        foreach ($this->getDulcesComprados() as $obj) {
            $obj->muestraResumen();
            echo "<br>";
        }
    }

    // Muestra un resumen de los atributos de la clase
    public function muestraResumen()
    {
        echo "<br>Nombre: " . $this->nombre . "<br>Cantidad de dulces: " . sizeof($this->getDulcesComprados());
    }
}
