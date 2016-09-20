<?php
/**
 * @package event
 */


namespace Mleko\Event;


interface EventNameExtractor
{
    /**
     * @param object $event
     * @return string
     */
    public function extract($event);
}
