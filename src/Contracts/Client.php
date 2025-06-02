<?php

declare(strict_types=1);

namespace Psonic\Contracts;

use Psonic\Exceptions\ConnectionException;

interface Client
{
    /**
     * @throws ConnectionException
     */
    public function connect(): void;

    public function disconnect(): void;

    public function send(Command $command): Response|false;

    public function read(): Response;
}
