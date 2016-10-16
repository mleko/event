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
    /** @var MutableEmitter */
    private $emitter;

    /**
     * Subscription constructor.
     * @param string $eventName
     * @param Listener $listener
     * @param MutableEmitter $emitter
     */
    public function __construct($eventName, Listener $listener, MutableEmitter $emitter)
    {
        $this->eventName = $eventName;
        $this->listener = $listener;
        $this->emitter = $emitter;
    }

    /**
     * @return bool
     */
    public function unsubscribe()
    {
        return $this->emitter->removeListener($this->eventName, $this->listener);
    }

}
