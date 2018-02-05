<?php

namespace Viviniko\Support\Event;

class Subscriber
{
    protected $handlers = [];

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        foreach ($this->handlers as $event => $handler) {
            $events->listen($event, static::class . '@' . $handler);
        }
    }
}