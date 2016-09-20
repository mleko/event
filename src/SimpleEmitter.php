<?php
/**
 * @package event
 */


namespace Mleko\Event;


class SimpleEmitter implements MutableEmitter
{

    /** @var array */
    private $listeners = [];

    /** @var EventNameExtractor */
    private $eventNameExtractor;

    /**
     * SimpleEventBus constructor.
     * @param EventNameExtractor $eventNameExtractor
     */
    public function __construct(EventNameExtractor $eventNameExtractor)
    {
        $this->eventNameExtractor = $eventNameExtractor;
    }

    /**
     * @param object $event
     * @return void
     */
    public function emit($event)
    {
        $eventName = $this->extractEventName($event);
        /** @var Listener[] $eventListeners */
        $eventListeners = array_key_exists($eventName, $this->listeners) ? $this->listeners[$eventName] : [];
        foreach ($eventListeners as $listener) {
            $listener->handle($event);
        }
    }

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return Subscription
     */
    public function addListener($eventName, Listener $listener)
    {
        $this->listeners[$eventName][] = $listener;
        return new Subscription($eventName, $listener, $this);
    }

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return bool
     */
    public function removeListener($eventName, Listener $listener)
    {
        $eventListeners = array_key_exists($eventName, $this->listeners) ? $this->listeners[$eventName] : [];
        foreach ($eventListeners as $key => $eventListener) {
            if ($listener === $eventListener) {
                unset($this->listeners[$eventName][$key]);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $event
     * @return string
     */
    private function extractEventName($event)
    {
        return $this->eventNameExtractor->extract($event);
    }
}
