<?php
declare(strict_types=1);

namespace Psonic\Commands\Ingest;

use Psonic\Commands\Command;

final class PushCommand extends Command
{
    private string $command = 'PUSH';

    /**
     * Push a text/object into an object/bucket respectively
     *
     * @param  string|null  $locale  - a Valid ISO 639-3 locale (eng = English), if set to `none` lexing will be disabled
     */
    public function __construct(string $collection, string $bucket, string $object, string $text, ?string $locale = null)
    {
        parent::__construct($this->command, [
            'collection' => $collection,
            'bucket'     => $bucket,
            'object'     => $object,
            'text'       => $this->wrapInQuotes($text),
            'locale'     => $locale ? "LANG($locale)": null,
        ]);
    }
}
