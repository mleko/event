<?php
/**
 * @package narrator
 */

namespace Mleko\Narrator;


interface ListenerResolver extends EventSource
{
    /**
     * @param object $event
     * @param EventSource $eventSource
     * @return ResolvedListener[]
     */
    public function getEventListeners($event, EventSource $eventSource);
}
