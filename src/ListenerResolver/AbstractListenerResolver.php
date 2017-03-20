<?php
/**
 * @package narrator
 */

namespace Mleko\Narrator\ListenerResolver;


use Mleko\Narrator\Listener;
use Mleko\Narrator\ListenerResolver;
use Mleko\Narrator\Subscription;

abstract class AbstractListenerResolver implements ListenerResolver
{
    /** @var Listener[][] */
    protected $listeners = [];

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return Subscription
     */
    public function subscribe($eventName, Listener $listener)
    {
        $this->listeners[$eventName][] = $listener;
        return new Subscription($eventName, $listener, $this);
    }

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return bool
     */
    public function unsubscribe($eventName, Listener $listener)
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
}
