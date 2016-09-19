<?php
/**
 * @package events
 */


namespace Mleko\Events;


interface Emitter
{
    /**
     * Emit event to listeners
     *
     * @param object $event
     * @return void
     */
    public function emit($event);
}
