<?php

declare(strict_types=1);

namespace src\app;

use src\util\LogFactory;
use Monolog\Logger;
use src\util\DulceNoCompradoException;
use src\util\DulceNoEncontradoException;
use src\util\ClienteNoEncontradoException;

include_once("./autoload.php");
//include_once("Bollo.php");
//include_once("Cliente.php");
//include_once("Chocolate.php");
//include_once("Tarta.php");

class Pasteleria
{
    private Logger $log;
    private $productos = [];
    private $clientes = [];

    public function __construct(
        private string $nombre
    ) {
        $this->log = LogFactory::getLogger();
    }

    /**
     * Get the value of productos
     */
    public function getProductos()
    {
        return $this->productos;
    }
    /**
     * Get the value of clientes
     */
    public function getClientes()
    {
        return $this->clientes;
    }
    /**
     * Get the value of numProductos
     */
    public function getNumProductos()
    {
        return count($this->getProductos());
    }
    /**
     * Get the value of numSocios
     */
    public function getNumClientes()
    {
        return count($this->getClientes());
    }

    // incluye productos en el array $productos
    private function incluirProducto(Dulce $d)
    {
        $this->log->info("Producto incluido", [$d->nombre]);
        $this->productos[] = $d;
    }

    // añade una cinta de video al videoclub y aumenta en +1 $numProductos
    public function incluirBollo($nombre, $precio, $relleno)
    {
        $bollo = new Bollo($nombre, $this->getNumProductos(), $precio, $relleno);
        $this->incluirProducto($bollo);
    }

    // añade un dvd al videoclub y aumenta en +1 $numProductos
    public function incluirChocolate($nombre, $precio, $porcentajeCacao, $peso)
    {
        $chocolate = new Chocolate($nombre, $this->getNumProductos(), $precio, $porcentajeCacao, $peso);
        $this->incluirProducto($chocolate);
    }

    // añade un juego al videoclub y aumenta en +1 $numProductos
    public function incluirTarta($nombre, $precio, $numPisos, $rellenos, $maxC, $minC = 0)
    {
        $tarta = new Tarta($nombre, $this->getNumProductos(), $precio, $numPisos, $rellenos, $maxC, $minC);
        $this->incluirProducto($tarta);
    }

    // añade un socio al videoclub y aumenta en +1 $numSocios
    public function incluirCliente($nombre, $numPedidosEfectuados = 0)
    {
        $cliente = new Cliente($nombre, $this->getNumClientes(), $numPedidosEfectuados);
        $this->clientes[] = $cliente;
    }

    // muestra todos los productos del videoclub
    public function listarProductos(): string
    {
        $str = "";
        foreach ($this->productos as $obj) {
            $str .= "<li>" . $obj->nombre . " ". $obj->getNumero() ."</li>";
        }
        return $str;
    }

    // muestra todos los socios del videoclub
    public function listarClientes(): string
    {
        $str = "";
        foreach ($this->clientes as $obj) {
            echo $obj->muestraResumen();
            $str .= "<li>" . $obj->nombre . "-------" . $obj->user . "</li>";
        }
        return $str;
    }

    
    // relaciona el método "comprar" de la clase cliente con un objeto heradado de dulce del array "$productos"
    public function comprarClienteProducto(int $numeroCliente, int $numeroDulce)
    {
        $saveCliente = "";
        $dulce = "";
        try {
            // recorro el array "$clientes"
            foreach ($this->clientes as $key => $obj) {
                //si el número de algún cliente coincide con el parámetro "$numCliente" recorro el array "$productos"
                if ($obj->getNumero() == $numeroCliente) {
                    $saveCliente = $obj; // Asigno aquí un cliente a esta variable para poder lanzar posteriormente ClienteNoEncontradoException
                        // recorro el array "$productos"
                        foreach ($this->productos as $value => $prod) {
                            // si el parámetro "$numeroDulce" coincide con algún número de productos el cliente comprará el dulce
                            if ($prod->getNumero() == $numeroDulce) {
                                $dulce = $prod;
                                $saveCliente->comprar($dulce);
                                return $this;
                            }
                        }
                        if($dulce == null){
                            $this->log->error("Dulce no encontrado", [$numeroDulce]);
                            throw new DulceNoEncontradoException();
                        }
                }
            }
            // en el caso de que "$saveCliente" esté vacío lanzaremos la excepción
            if ($saveCliente == "") {
                $this->log->critical("Cliente no encontrado", [$numeroCliente]);
                throw new ClienteNoEncontradoException();
            }
        } catch (ClienteNoEncontradoException $e) {
            echo $e->getMessage();
        } catch (DulceNoEncontradoException $e) {
            echo $e->getMessage();
        }
        return $this;
    }

}
