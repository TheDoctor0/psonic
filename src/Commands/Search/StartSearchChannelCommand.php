<?php

declare(strict_types=1);

namespace Psonic\Commands\Search;

use Psonic\Commands\Command;

final class StartSearchChannelCommand extends Command
{
    private string $command = 'START';

    public function __construct(string $password)
    {
        parent::__construct($this->command, [
            'mode' => 'search',
            'password' => $password,
        ]);
    }
}
