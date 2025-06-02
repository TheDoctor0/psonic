<?php

declare(strict_types=1);

namespace Psonic\Commands\Control;

use Psonic\Commands\Command;

final class StartControlChannelCommand extends Command
{
    private string $command = 'START';

    public function __construct(string $password)
    {
        parent::__construct($this->command, [
            'mode' => 'control',
            'password' => $password,
        ]);
    }
}
