<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\EventNameExtractor;


class ClassNameExtractor implements \Mleko\Narrator\EventNameExtractor
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
