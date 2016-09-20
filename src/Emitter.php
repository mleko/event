<?php
/**
 * @package event
 */


namespace Mleko\Event;


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
