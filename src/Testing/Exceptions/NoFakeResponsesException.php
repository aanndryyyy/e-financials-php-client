<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Exceptions;

use RuntimeException;

final class NoFakeResponsesException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('No fake responses left.');
    }
}
