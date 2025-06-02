<?php

declare(strict_types=1);

namespace Psonic\Commands\Misc;

use Psonic\Commands\Command;


final class PingCommand extends Command
{
    private string $command = 'PING';

    public function __construct()
    {
        parent::__construct($this->command);
    }
}
