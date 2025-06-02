<?php

declare(strict_types=1);

namespace Psonic;

use Psonic\Channels\Channel;
use Psonic\Commands\Search\QueryCommand;
use Psonic\Commands\Search\SuggestCommand;
use Psonic\Exceptions\CommandFailedException;
use Psonic\Commands\Search\StartSearchChannelCommand;

class Search extends Channel
{
    /**
     * @throws Exceptions\ConnectionException
     */
    public function connect(string $password = 'SecretPassword'): Contracts\Response
    {
        parent::connect();

        $response = $this->send(new StartSearchChannelCommand($password));

        if ($bufferSize = $response->get('bufferSize')) {
            $this->bufferSize = (int) $bufferSize;
        }

        return $response;
    }

    /**
     * @throws CommandFailedException
     */
    public function query(string $collection, string $bucket, string $terms, ?int $limit = null, ?int $offset = null, ?string $locale = null): array
    {
        $response = $this->send(new QueryCommand($collection, $bucket, $terms, $limit, $offset, $locale));

        if ($response->getStatus() === 'PENDING') {
            throw new CommandFailedException($response->getStatus());
        }

        $results = $this->read();

        if ($results->getStatus() === 'EVENT') {
            throw new CommandFailedException($response->getStatus());
        }

        return $results->getResults();
    }

    /**
     * @throws CommandFailedException
     */
    public function suggest(string $collection, string $bucket, string $terms, ?int $limit = null): array
    {
        $response = $this->send(new SuggestCommand($collection, $bucket, $terms, $limit));

        if ($response->getStatus() === 'PENDING') {
            throw new CommandFailedException($response->getStatus());
        }

        $results = $this->read();

        if ($results->getStatus() === 'EVENT') {
            throw new CommandFailedException($response->getStatus());
        }

        return $results->getResults();
    }
}
