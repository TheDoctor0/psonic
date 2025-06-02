<?php

declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class PopCommand extends Command
{
    private string $command = 'POP';

    public function __construct(string $collection, string $bucket, string $object, string $text)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'object'     => $object,
            'text'       => $this->wrapInQuotes($text),
        ]);
    }
}
