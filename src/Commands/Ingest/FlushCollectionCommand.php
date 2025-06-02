<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class FlushCollectionCommand extends Command
{
    private string $command = 'FLUSHC';

    public function __construct(string $collection)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
        ]);
    }
}
