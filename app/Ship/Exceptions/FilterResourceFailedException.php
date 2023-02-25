<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class FilterResourceFailedException extends Exception
{
    protected $code = Response::HTTP_EXPECTATION_FAILED;
    protected $message = 'Failed to receive Resource.';
}
