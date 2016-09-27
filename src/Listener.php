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
     * @param Meta $meta
     */
    public function handle($event, Meta $meta);
}
