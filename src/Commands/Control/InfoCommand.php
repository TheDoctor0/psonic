<?php

declare(strict_types=1);

namespace Psonic\Commands\Control;

use Psonic\Commands\Command;

final class InfoCommand extends Command
{
    private string $command = 'INFO';

    public function __construct()
    {
        parent::__construct($this->command);
    }
}
