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
    /** @var Emitter */
    private $emitter;

    /**
     * Meta constructor.
     * @param object $event
     * @param string $eventName
     * @param string $matchedName
     * @param Emitter $emitter
     */
    public function __construct($event, $eventName, $matchedName, Emitter $emitter)
    {
        $this->event = $event;
        $this->eventName = $eventName;
        $this->matchedName = $matchedName;
        $this->emitter = $emitter;
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
     * @return Emitter
     */
    public function getEmitter()
    {
        return $this->emitter;
    }

    
}
