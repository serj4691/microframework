<?php

namespace Framework\Http\Pipeline;

use InvalidArgumentException;

class UnknownMiddlewareTypeException extends InvalidArgumentException
{
    public $type;

    public function __construct($type)
    {
        parent::__construct('Unknown middleware type',0,null);
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }
}
