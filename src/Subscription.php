<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


class Subscription
{
    /** @var string */
    private $eventName;
    /** @var Listener */
    private $listener;
    /** @var EventSource */
    private $eventSource;

    /**
     * Subscription constructor.
     * @param string $eventName
     * @param Listener $listener
     * @param EventSource $emitter
     */
    public function __construct($eventName, Listener $listener, EventSource $emitter)
    {
        $this->eventName = $eventName;
        $this->listener = $listener;
        $this->eventSource = $emitter;
    }

    /**
     * @return bool
     */
    public function unsubscribe()
    {
        return $this->eventSource->unsubscribe($this->eventName, $this->listener);
    }

}
