<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


interface EventNameExtractor
{
    /**
     * @param object $event
     * @return string
     */
    public function extract($event);
}
