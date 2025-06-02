<?php

declare(strict_types=1);

namespace Psonic\Contracts;

interface Command
{
    public function __toString(): string;
}
