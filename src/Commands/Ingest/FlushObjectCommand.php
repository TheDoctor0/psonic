<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class FlushObjectCommand extends Command
{
    private string $command = 'FLUSHO';

    public function __construct(string $collection, string $bucket, string $object)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'object'     => $object,
        ]);
    }
}
