<?php
/**
 * @package events
 */


namespace Mleko\Events\EventNameExtractor;


class ClassNameExtractor implements \Mleko\Events\EventNameExtractor
{

    /**
     * @param object $event
     * @return string
     */
    public function extract($event)
    {
        return get_class($event);
    }
}
