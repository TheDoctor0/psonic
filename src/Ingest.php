<?php

declare(strict_types=1);

namespace Psonic;

use Psonic\Channels\Channel;
use InvalidArgumentException;
use Psonic\Commands\Ingest\PopCommand;
use Psonic\Commands\Ingest\PushCommand;
use Psonic\Commands\Ingest\CountCommand;
use Psonic\Commands\Ingest\FlushObjectCommand;
use Psonic\Commands\Ingest\FlushBucketCommand;
use Psonic\Commands\Ingest\FlushCollectionCommand;
use Psonic\Commands\Ingest\StartIngestChannelCommand;

class Ingest extends Channel
{
    /**
     * @throws Exceptions\ConnectionException
     */
    public function connect(string $password = 'SecretPassword'): Contracts\Response
    {
        parent::connect();

        $response = $this->send(new StartIngestChannelCommand($password));

        if ($bufferSize = $response->get('bufferSize')) {
            $this->bufferSize = (int) $bufferSize;
        }

        return $response;
    }

    public function push(string $collection, string $bucket, string $object, string $text, ?string $locale = null): ?Contracts\Response
    {
        $chunks = $this->splitString($collection, $bucket, $object, $text);

        if ($text === '' || empty($chunks)) {
            throw new InvalidArgumentException("The parameter \$text is empty");
        }

        foreach ($chunks as $chunk) {
            $message = $this->send(new PushCommand($collection, $bucket, $object, $chunk, $locale));

            if (! ((string) $message)) {
                throw new InvalidArgumentException();
            }
        }

        return $message ?? null;
    }

    public function pop(string $collection, string $bucket, string $object, string $text): int
    {
        $chunks = $this->splitString($collection, $bucket, $object, $text);
        $count  = 0;

        foreach ($chunks as $chunk) {
            $message = $this->send(new PopCommand($collection, $bucket, $object, $chunk));

            if (! ((string) $message)) {
                throw new InvalidArgumentException();
            }

            $count += (int) $message->get('count');
        }

        return $count;
    }

    public function count(string $collection, ?string $bucket = null, ?string $object = null): int
    {
        $message = $this->send(new CountCommand($collection, $bucket, $object));

        return (int) $message->get('count');
    }

    public function flushc(string $collection): int
    {
        return $this->send(new FlushCollectionCommand($collection))->getCount();
    }

    public function flushb(string $collection, string $bucket): int
    {
        return $this->send(new FlushBucketCommand($collection, $bucket))->getCount();
    }

    public function flusho(string $collection, string $bucket, string $object): int
    {
        return $this->send(new FlushObjectCommand($collection, $bucket, $object))->getCount();
    }

    private function splitString(string $collection, string $bucket, string $key, string $text): array
    {
        return str_split($text, ($this->bufferSize - (strlen($key . $collection . $bucket) + 20)));
    }
}
