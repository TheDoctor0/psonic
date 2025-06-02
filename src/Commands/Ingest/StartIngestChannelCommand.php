<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class StartIngestChannelCommand extends Command
{
    private string $command = 'START';

    public function __construct(string $password)
    {
        parent::__construct($this->command, [
            'mode' => 'ingest',
            'password' => $password,
        ]);
    }
}
