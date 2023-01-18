<?php

declare(strict_types=1);

namespace src\util;
include_once("./autoload.php");
//include_once("PasteleriaException.php");

class ClienteNoEncontradoException extends PasteleriaException{
    
    public function __construct(
        $message = "</br>No se pudo encontrar al cliente",
        $code = 1
    )
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}