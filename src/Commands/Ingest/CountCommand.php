<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class CountCommand extends Command
{
    private string $command = 'COUNT';

    public function __construct(string $collection, string $bucket = null, ?string $object = null)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'object'     => $object,
        ]);
    }
}
