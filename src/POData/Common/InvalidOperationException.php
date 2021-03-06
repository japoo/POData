<?php

declare(strict_types=1);

namespace POData\Common;

use Exception;

/**
 * Class InvalidOperationException.
 */
class InvalidOperationException extends Exception
{
    /**
     * Creates new instance of InvalidOperationException.
     *
     * @param string $message The error message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
