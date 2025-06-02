<?php

declare(strict_types=1);

namespace Psonic\Commands\Misc;

use Psonic\Commands\Command;


final class QuitChannelCommand extends Command
{
    private string $command = 'QUIT';

    public function __construct()
    {
        parent::__construct($this->command);
    }
}
