<?php

declare(strict_types=1);

namespace Psonic;

use Psonic\Exceptions\ConnectionException;
use Psonic\Contracts\Client as ClientInterface;
use Psonic\Contracts\Command as CommandInterface;
use Psonic\Contracts\Response as ResponseInterface;

class Client implements ClientInterface
{
    private mixed $resource;
    private string $host;
    private int $port;
    private ?int $errorNo = null;
    private ?string $errorMessage = null;
    private int $maxTimeout;

    public function __construct(string $host = 'localhost', int $port = 1491, int $timeout = 30)
    {
        $this->host = $host;
        $this->port = $port;
        $this->maxTimeout = $timeout;
    }

    /**
     * @throws \Psonic\Exceptions\ConnectionException
     * @throws \Psonic\Exceptions\CommandFailedException
     */
    public function send(CommandInterface $command): ResponseInterface
    {
        if (! $this->resource) {
            throw new ConnectionException();
        }

        fwrite($this->resource, (string) $command);

        return $this->read();
    }

    /**
     * @throws \Psonic\Exceptions\CommandFailedException
     */
    public function read(): ResponseInterface
    {
        $message = explode("\r\n", fgets($this->resource))[0];

        return new SonicResponse($message);
    }

    /**
     * @throws ConnectionException
     */
    public function connect(): void
    {
        if (! $this->resource = stream_socket_client("tcp://$this->host:$this->port", $this->errorNo, $this->errorMessage, $this->maxTimeout)) {
            throw new ConnectionException();
        }
    }

    /**
     * Disconnects from a socket
     */
    public function disconnect(): void
    {
        stream_socket_shutdown($this->resource, STREAM_SHUT_WR);

        $this->resource = null;
    }

    public function clearBuffer(): bool
    {
        stream_get_line($this->resource, 4096, "\r\n");

        return true;
    }
}
