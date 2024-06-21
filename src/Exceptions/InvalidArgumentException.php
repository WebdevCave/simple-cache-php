<?php

namespace Webdevcave\SimpleCache\Exceptions;

use Exception;
use Psr\SimpleCache\InvalidArgumentException as InvalidArgumentExceptionInterface;

class InvalidArgumentException extends Exception implements InvalidArgumentExceptionInterface
{

}
