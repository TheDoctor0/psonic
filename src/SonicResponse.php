<?php

declare(strict_types=1);

namespace Psonic;

use Psonic\Contracts\Response as ResponseInterface;
use Psonic\Exceptions\CommandFailedException;

class SonicResponse implements ResponseInterface 
{
    private string $message;
    private array $pieces;
    private mixed $results;

    /**
     * @throws \Psonic\Exceptions\CommandFailedException
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->parse();
    }

    /**
     * @throws CommandFailedException
     */
    private function parse(): void
    {
        $this->pieces = explode(" ", $this->message);

        if (preg_match_all("/buffer\((\d+)\)/", $this->message, $matches)) {
            $this->pieces['bufferSize'] = $matches[1][0];
        }

        $this->pieces['status'] = $this->pieces[0];

        unset($this->pieces[0]);

        if ($this->pieces['status'] === 'ERR') {
            throw new CommandFailedException($this->message);
        }

        if ($this->pieces['status'] === 'RESULT') {
            $this->pieces['count'] = (int) $this->pieces[1];

            unset($this->pieces[1]);
        }

        if ($this->pieces['status'] === 'EVENT') {
            $this->pieces['query_key'] = $this->pieces[2];
            $this->results = array_slice($this->pieces, 2, count($this->pieces)-4);
        }
    }

    public function getResults(): mixed
    {
        return $this->results;
    }

    public function __toString()
    {
        return implode(" ", $this->pieces);
    }

    public function get(string $key): mixed
    {
        return $this->pieces[$key] ?? null;
    }

    public function getStatus(): string
    {
        return $this->get('status');
    }

    public function getCount(): int
    {
        return (int) ($this->get('count') ?? 0);
    }
}
