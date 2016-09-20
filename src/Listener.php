<?php
/**
 * @package event
 */


namespace Mleko\Event;


interface Listener
{
    /**
     * Handle an event
     *
     * @param object $event
     */
    public function handle($event);
}
