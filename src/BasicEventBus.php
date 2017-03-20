<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


class BasicEventBus implements EventBus
{

    /** @var ListenerResolver */
    private $listenerResolver;

    /**
     * SimpleEventBus constructor.
     * @param ListenerResolver $listenerResolver
     * @param Listener[][] $listeners
     */
    public function __construct(ListenerResolver $listenerResolver, array $listeners = [])
    {
        $this->listenerResolver = $listenerResolver;
        foreach ($listeners as $eventName => $eventListeners) {
            foreach ($eventListeners as $listener) {
                $this->subscribe($eventName, $listener);
            }
        }
    }

    /**
     * @param object $event
     * @return void
     */
    public function emit($event)
    {
        $resolvedListeners = $this->listenerResolver->getEventListeners($event, $this);
        foreach ($resolvedListeners as $resolvedListener) {
            $resolvedListener->emit($event);
        }
    }

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return Subscription
     */
    public function subscribe($eventName, Listener $listener)
    {
        return $this->listenerResolver->subscribe($eventName, $listener);
    }

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return bool
     */
    public function unsubscribe($eventName, Listener $listener)
    {
        return $this->listenerResolver->unsubscribe($eventName, $listener);
    }
}
