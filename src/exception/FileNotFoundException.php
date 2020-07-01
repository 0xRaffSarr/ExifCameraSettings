<?php

namespace xrs\exifData\exception;

use Exception;
use Throwable;

class FileNotFoundException extends Exception
{
    public function __construct($file = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("File: " .$file. " not found", $code, $previous);
    }
}
