<?php
/**
 * @package events
 */


namespace Mleko\Events;


interface EventNameExtractor
{
    /**
     * @param object $event
     * @return string
     */
    public function extract($event);
}
