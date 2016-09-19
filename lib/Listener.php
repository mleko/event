<?php
/**
 * @package events
 */


namespace Mleko\Events;


interface Listener
{
    /**
     * Handle an event
     *
     * @param object $event
     */
    public function handle($event);
}
