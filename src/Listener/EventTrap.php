<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Listener;


class EventTrap implements \Mleko\Narrator\Listener
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
     * @param \Mleko\Narrator\Meta $meta
     */
    public function handle($event, \Mleko\Narrator\Meta $meta)
    {
        if ($this->oneTime) {
            $this->close($meta);
            if (!empty($this->trappedEvents)) {
                return;
            }
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

    /**
     * @param \Mleko\Narrator\Meta $meta
     * @return bool
     */
    public function close(\Mleko\Narrator\Meta $meta)
    {
        return $meta->getEventSource()->unsubscribe($meta->getMatchedName(), $this);
    }

}
