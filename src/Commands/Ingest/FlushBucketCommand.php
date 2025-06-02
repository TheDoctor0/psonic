<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class FlushBucketCommand extends Command
{
    private string $command = 'FLUSHB';

    public function __construct(string $collection, string $bucket)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
        ]);
    }
}
