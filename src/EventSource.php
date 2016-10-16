<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


interface EventSource
{
    /**
     * @param string $eventName
     * @param Listener $listener
     * @return Subscription
     */
    public function subscribe($eventName, Listener $listener);

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return bool
     */
    public function unsubscribe($eventName, Listener $listener);
}
