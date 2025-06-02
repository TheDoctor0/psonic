<?php

declare(strict_types=1);

namespace Psonic\Commands\Search;

use Psonic\Commands\Command;

final class QueryCommand extends Command
{
    private string $command = 'QUERY';

    public function __construct(string $collection, string $bucket, string $terms, ?int $limit = null, ?int $offset = null, ?string $locale = null)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'terms'      => $this->wrapInQuotes($terms),
            'limit'      => $limit ? "LIMIT($limit)": null,
            'offset'     => $offset ? "OFFSET($offset)": null,
            'locale'     => $locale ? "LANG($locale)": null,
        ]);
    }
}
