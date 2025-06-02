<?php

declare(strict_types=1);

namespace Psonic;

use Psonic\Channels\Channel;
use Psonic\Commands\Control\InfoCommand;
use Psonic\Commands\Control\TriggerCommand;
use Psonic\Commands\Control\StartControlChannelCommand;

class Control extends Channel
{
    public function connect(string $password = 'SecretPassword'): Contracts\Response
    {
        parent::connect();

        $response = $this->send(new StartControlChannelCommand($password));

        if ($bufferSize = $response->get('bufferSize')) {
            $this->bufferSize = (int)$bufferSize;
        }

        return $response;
    }

    public function trigger(string $action): Contracts\Response
    {
        return $this->send(new TriggerCommand($action));
    }

    public function consolidate(): Contracts\Response
    {
        return $this->trigger('consolidate');
    }

    public function info(): Contracts\Response
    {
        return $this->send(new InfoCommand);
    }
}
