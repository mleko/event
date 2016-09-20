<?php
/**
 * @package event
 */


namespace Mleko\Event\EventNameExtractor;


class ClassNameExtractor implements \Mleko\Event\EventNameExtractor
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
