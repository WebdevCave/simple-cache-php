<?php

namespace Webdevcave\SimpleCache\Exceptions;

use Exception;
use Psr\SimpleCache\CacheException as CacheExceptionInterface;

class CacheException extends Exception implements CacheExceptionInterface
{

}
