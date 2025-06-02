<?php

declare(strict_types=1);

namespace Psonic\Commands\Search;

use Psonic\Commands\Command;

final class SuggestCommand extends Command
{
    private string $command = 'SUGGEST';

    public function __construct(string $collection, string $bucket, string $terms, ?int $limit = null)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'terms'      => $this->wrapInQuotes($terms),
            'limit'      => $limit ? "LIMIT($limit)" : null,
        ]);
    }
}
