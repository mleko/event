<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


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
