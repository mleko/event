<?php
/**
 * @package event
 */


namespace Mleko\Event\Listener;


class EventTrap implements \Mleko\Event\Listener
{

    /** @var object[] */
    private $trappedEvents;

    /** @var boolean */
    private $oneTime;

    /**
     * EventTrap constructor.
     * @param bool $oneTime
     */
    public function __construct($oneTime = true)
    {
        $this->oneTime = $oneTime;
        $this->trappedEvents = [];
    }


    /**
     * @param object $event
     * @param \Mleko\Event\Meta $meta
     */
    public function handle($event, \Mleko\Event\Meta $meta)
    {
        if ($this->oneTime && !empty($this->trappedEvents)) {
            return;
        }
        $this->trappedEvents[] = $event;
    }

    /**
     * @return object[]
     */
    public function getTrappedEvents()
    {
        return $this->trappedEvents;
    }

    /**
     * @return null|object
     */
    public function getFirstEvent()
    {
        return isset($this->trappedEvents[0]) ? $this->trappedEvents[0] : null;
    }

}
