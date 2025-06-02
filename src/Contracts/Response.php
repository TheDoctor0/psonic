<?php

declare(strict_types=1);

namespace Psonic\Contracts;

interface Response
{
    public function get(string $key): mixed;

    public function getStatus(): string;
}
