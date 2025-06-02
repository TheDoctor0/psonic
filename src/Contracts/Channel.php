<?php

declare(strict_types=1);

namespace Psonic\Contracts;

use Psonic\Exceptions\ConnectionException;

interface Channel
{
    /**
     * @throws ConnectionException
     */
    public function connect(): Response;

    public function disconnect(): Response;
}
