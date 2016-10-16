<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


interface MutableEmitter extends Emitter
{
    /**
     * @param string $eventName
     * @param Listener $listener
     * @return Subscription
     */
    public function addListener($eventName, Listener $listener);

    /**
     * @param string $eventName
     * @param Listener $listener
     * @return bool
     */
    public function removeListener($eventName, Listener $listener);
}
