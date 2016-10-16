<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


interface EventEmitter
{
    /**
     * Emit event to listeners
     *
     * @param object $event
     * @return void
     */
    public function emit($event);
}
