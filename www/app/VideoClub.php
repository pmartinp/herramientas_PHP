<?php

declare(strict_types=1);

namespace Examen_Servidor_1Trimestre\app;

use Examen_Servidor_1Trimestre\util\ClienteNoEncontradoException;
use Examen_Servidor_1Trimestre\util\CupoSuperadoException;
use Examen_Servidor_1Trimestre\util\SoporteNoEncontradoException;
use Examen_Servidor_1Trimestre\util\SoporteYaAlquiladoException;

include_once("./autoload.php");
//include_once("CintaVideo.php");
//include_once("Cliente.php");
//include_once("Disco.php");
//include_once("Juego.php");

class VideoClub
{

    public $productos = [];
    private $socios = [];
    private int $numProductosAlquilados;
    private int $numTotalAlquileres;

    public function __construct(
        private string $nombre
    ) {
    }

    /**
     * Get the value of numProductos
     */
    public function getNumProductos()
    {
        return count($this->productos);
    }
    /**
     * Get the value of numSocios
     */
    public function getNumSocios()
    {
        return count($this->socios);
    }
    /**
     * Get the value of numProductosAlquilados
     */
    public function getNumProductosAlquilados()
    {
        return $this->numProductosAlquilados;
    }
    /**
     * Get the value of numTotalAlquileres
     */
    public function getNumTotalAlquileres()
    {
        return $this->numTotalAlquileres;
    }

    // incluye productos en el array $productos
    private function incluirProducto(Soporte $s)
    {
        $this->productos[] = $s;
    }

    // añade una cinta de video al videoclub y aumenta en +1 $numProductos
    public function incluirCintaVideo($titulo, $precio, $duracion)
    {
        $cintaVideo = new CintaVideo($titulo, $this->getNumProductos(), $precio, $duracion);
        $this->incluirProducto($cintaVideo);
    }

    // añade un dvd al videoclub y aumenta en +1 $numProductos
    public function incluirDVD($titulo, $precio, $idiomas, $pantalla)
    {
        $dvd = new Disco($titulo, $this->getNumProductos(), $precio, $idiomas, $pantalla);
        $this->incluirProducto($dvd);
    }

    // añade un juego al videoclub y aumenta en +1 $numProductos
    public function incluirJuego($titulo, $precio, $consola, $minJ, $maxJ)
    {
        $juego = new Juego($titulo, $this->getNumProductos(), $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($juego);
    }

    // añade un socio al videoclub y aumenta en +1 $numSocios
    public function incluirSocio($nombre, $maxAlquileresConcurrentes = 3)
    {
        $socio = new Cliente($nombre, $this->getNumSocios(), $maxAlquileresConcurrentes);
        $this->socios[] = $socio;
    }

    // muestra todos los productos del videoclub
    public function listarProductos(): string
    {
        $str = "";
        foreach ($this->productos as $obj) {
            $str .= "<li>" . $obj->titulo . "</li>";
        }
        return $str;
    }

    // muestra todos los socios del videoclub
    public function listarSocios(): string
    {
        $str = "";
        foreach ($this->socios as $obj) {
            $str .= "<li>" . $obj->nombre . "-------" . $obj->user . "</li>";
        }
        return $str;
    }

    // relaciona el método "alquilar" de la clase socio con un objeto heradado de soporte del array "$productos"
    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte)
    {
        $saveCliente = "";
        try {
            // recorro el array "$socios"
            foreach ($this->socios as $key => $obj) {
                //si el número de algún socio coincide con el parámetro "$numCliente" recorro el array "$productos"
                if ($obj->getNumero() == $numeroCliente) {
                    $saveCliente = $obj; // Asigno aquí un cliente a esta variable para poder lanzar posteriormente ClienteNoEncontradoException
                    try {
                        // recorro el array "$productos"
                        foreach ($this->productos as $value => $prod) {
                            // si el parámetro "$numeroSoporte" coincide con algún número de productos el socio alquilará el producto
                            if ($prod->getNumero() == $numeroSoporte) {
                                $obj->alquilar($prod);
                                return $this;
                            }
                        }
                    } catch (SoporteYaAlquiladoException $e) {
                        echo $e->getMessage();
                    } catch (CupoSuperadoException $e) {
                        echo $e->getMessage();
                    }
                }
            }
            // en el caso de que "$saveCliente" esté vacío lanzaremos la excepción
            if ($saveCliente == "") {
                throw new ClienteNoEncontradoException();
            }
        } catch (ClienteNoEncontradoException $e) {
            echo $e->getMessage();
        }
        return $this;
    }

    // relaciona el método "alquilar" de la clase socio con varios objetos heradado de soporte del array "$productos"
    public function alquilaSocioProductos(int $numeroSocio, array $numerosProductos)
    {
        $saveCliente = "";
        try {
            // recorro el array "$socios"
            foreach ($this->socios as $key => $obj) {
                //si el número de algún socio coincide con el parámetro "$numCliente" recorro el array "$productos"
                if ($obj->getNumero() == $numeroSocio) {
                    $saveCliente = $obj; // Asigno aquí un cliente a esta variable para poder lanzar posteriormente ClienteNoEncontradoException
                    try {
                        // recorro el array "$productos" para comprobar si hay algún soporte alquilado
                        foreach ($numerosProductos as $prod) {
                            // si el parámetro "$numeroSoporte" coincide con algún número de productos el socio alquilará el producto
                            if ($prod->alquilado) {
                                throw new SoporteYaAlquiladoException();
                            }
                        }
                        // Si no hay ningún soporte alquilado recorro el array "$productos" para alquilar los productos
                        foreach ($numerosProductos as $prod) {
                            $obj->alquilar($prod);
                        }
                        return $this;
                    } catch (SoporteYaAlquiladoException $e) {
                        echo $e->getMessage();
                    } catch (CupoSuperadoException $e) {
                        echo $e->getMessage();
                    }
                }
            }
            // en el caso de que "$saveCliente" esté vacío lanzaremos la excepción
            if ($saveCliente == "") {
                throw new ClienteNoEncontradoException();
            }
        } catch (ClienteNoEncontradoException $e) {
            echo $e->getMessage();
        }
        return $this;
    }

    // relaciona el método "devolver" de la clase socio con un objeto heradado de soporte del array "$productos"
    public function devolverSocioProducto(int $numeroCliente, int $numeroSoporte)
    {
        $saveCliente = "";
        try {
            // recorro el array "$socios"
            foreach ($this->socios as $key => $obj) {
                //si el número de algún socio coincide con el parámetro "$numeroCliente" intento devolver el soporte
                if ($obj->getNumero() == $numeroCliente) {
                    $saveCliente = $obj; // Asigno aquí un cliente a esta variable para poder lanzar posteriormente ClienteNoEncontradoException
                    try {
                        $obj->devolver($numeroSoporte);
                    } catch (SoporteNoEncontradoException $e) {
                        echo $e->getMessage();
                    }
                }
            }
            // en el caso de que "$saveCliente" esté vacío lanzaremos la excepción
            if ($saveCliente == "") {
                throw new ClienteNoEncontradoException();
            }
        } catch (ClienteNoEncontradoException $e) {
            echo $e->getMessage();
        }
        return $this;
    }

    // relaciona el método "devolver" de la clase socio con varios objetos heradado de soporte del array "$productos"
    public function devolverSocioProductos(int $numeroSocio, array $numerosProductos)
    {
        $saveCliente = "";
        try {
            // recorro el array "$socios"
            foreach ($this->socios as $key => $obj) {
                //si el número de algún socio coincide con el parámetro "$numCliente" recorro el array "$productos"
                if ($obj->getNumero() == $numeroSocio) {
                    $saveCliente = $obj; // Asigno aquí un cliente a esta variable para poder lanzar posteriormente ClienteNoEncontradoException
                    try {
                        // recorro el array "$productos" para comprobar si hay algún soporte alquilado
                        foreach ($numerosProductos as $prod) {
                            // si el socio no tiene alquilado algún producto de los que trata de devovler lanzará SoporteNoEncontradoException
                            if (!$obj->tieneAlquilado($prod)) {
                                throw new SoporteNoEncontradoException();
                            }
                        }
                        // Si todos los soportes están alquilado recorro el array "$productos" para devolver los productos
                        foreach ($numerosProductos as $prod) {
                            $obj->devolver($prod->getNumero());
                        }
                        return $this;
                    } catch (SoporteNoEncontradoException $e) {
                        echo $e->getMessage();
                    }
                }
            }
            // en el caso de que "$saveCliente" esté vacío lanzaremos la excepción
            if ($saveCliente == "") {
                throw new ClienteNoEncontradoException();
            }
        } catch (ClienteNoEncontradoException $e) {
            echo $e->getMessage();
        }
        return $this;
    }
}
