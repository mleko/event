<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator;


class Meta
{
    /** @var object */
    private $event;
    /** @var string */
    private $eventName;
    /** @var string */
    private $matchedName;
    /** @var EventSource */
    private $eventSource;

    /**
     * Meta constructor.
     * @param object $event
     * @param string $eventName
     * @param string $matchedName
     * @param EventSource $eventSource
     */
    public function __construct($event, $eventName, $matchedName, EventSource $eventSource)
    {
        $this->event = $event;
        $this->eventName = $eventName;
        $this->matchedName = $matchedName;
        $this->eventSource = $eventSource;
    }

    /**
     * @return object
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return string
     */
    public function getMatchedName()
    {
        return $this->matchedName;
    }

    /**
     * @return EventSource
     */
    public function getEventSource()
    {
        return $this->eventSource;
    }

    
}
