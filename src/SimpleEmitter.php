<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


class SimpleEmitter implements MutableEmitter
{

    /** @var array */
    private $listeners = [];

    /** @var EventNameExtractor */
    private $eventNameExtractor;

    /**
     * SimpleEventBus constructor.
     * @param EventNameExtractor $eventNameExtractor
     * @param Listener[][] $listeners
     */
    public function __construct(EventNameExtractor $eventNameExtractor, array $listeners = [])
    {
        $this->eventNameExtractor = $eventNameExtractor;
        foreach ($listeners as $eventName => $eventListeners) {
            foreach ($eventListeners as $listener) {
                $this->addListener($eventName, $listener);
            }
        }
    }

    /**
     * @param object $event
     * @return void
     */
    public function emit($event)
    {
        $eventName = $this->extractEventName($event);
        $eventListeners = $this->getEventListeners($eventName);
        $eventMeta = new Meta($event, $eventName, $eventName, $this);
        foreach ($eventListeners as $listener) {
            $listener->handle($event, $eventMeta);
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
        $eventListeners = $this->getEventListeners($eventName);
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

    /**
     * @param string $eventName
     * @return Listener[]
     */
    private function getEventListeners($eventName)
    {
        $eventListeners = array_key_exists($eventName, $this->listeners) ? $this->listeners[$eventName] : [];
        return $eventListeners;
    }
}
