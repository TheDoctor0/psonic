<?php

declare(strict_types=1);

namespace Psonic\Commands\Control;

use Psonic\Commands\Command;

final class TriggerCommand extends Command
{
    private string $command = 'TRIGGER';

    public function __construct(string $action)
    {
        parent::__construct($this->command, [
            'action' => $action,
        ]);
    }
}
