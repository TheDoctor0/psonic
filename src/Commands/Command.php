<?php

namespace Psonic\Commands;

use Psonic\Contracts\Command as CommandInterface;

abstract class Command implements CommandInterface
{
    private string $command;
    private array $parameters;

    public function __construct(string $command, array $parameters = [])
    {
        $this->command = $command;
        $this->parameters = $parameters;
    }

    /**
     * Wrap the string in quotes, and normalize whitespace. Also remove double quotes.
     */
    protected function wrapInQuotes($string): string
    {
        $string = preg_replace('/[\r\n\t"]/', ' ', $string);

        return '"' . str_replace('"', '\"', $string) . '"';
    }

    public function __toString(): string
    {
        return $this->command . " " . implode(" ", $this->parameters) . "\n";
    }
}
