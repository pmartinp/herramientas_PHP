<?php

declare(strict_types=1);

namespace src\app;

use src\util\LogFactory;
use Monolog\Logger;
use src\util\DulceNoCompradoException;

class Cliente
{

    private Logger $log;
    private $dulcesComprados = [];
    public string $user;

    public function __construct(
        public string $nombre,
        private int $numero,
        private int $numPedidosEfectuados = 0,
        private string $password = "usuario"
    ) {
        $this->log = LogFactory::getLogger();
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
     * Set the value of numPedidosEfectuados
     *
     * @return  self
     */
    public function setNumPedidosEfectuados($numPedidosEfectuados)
    {
        $this->numPedidosEfectuados = $numPedidosEfectuados;

        return $this;
    }

    // comprueba si es posible compprar un dulce y si lo es lo añade al array dulcesComprados (lo compra)
    public function comprar(Dulce $d)
    {
        $this->setNumPedidosEfectuados($this->getNumPedidosEfectuados() + 1);
        $this->dulcesComprados[] = $d;
        echo "<br>Dulce comprado con éxito";
        return $this;
    }

    // comprueba si el parámetro $d está comprado o no
    public function listaDeDulces(Dulce $d): bool
    {
        return in_array($d, $this->getDulcesComprados());
    }

    // Realiza una valoración del dulce comprado
    public function valorar(Dulce $d, String $c)
    {
        if ($this->listaDeDulces($d)) {

            echo $c;
        } else {
            $this->log->warning("Dulce no comprado", [$d->nombre]);
            throw new DulceNoCompradoException();
        }
        return $this;
    }

    // Lista los dulces, con sus características que ha comprado el cliente
    public function listarPedidos()
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
