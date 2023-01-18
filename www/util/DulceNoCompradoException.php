<?php

declare(strict_types=1);

namespace www\util;
include_once("./autoload.php");
//include_once("PasteleriaException.php");

class DulceNoCompradoException extends PasteleriaException{
    
    public function __construct(
        $message = "</br>El dulce no ha sido comprado</br>",
        $code = 3
    )
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}