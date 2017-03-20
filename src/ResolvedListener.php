<?php
/**
 * @package narrator
 */

namespace Mleko\Narrator;


class ResolvedListener
{
    /** @var Listener */
    private $listener;
    /** @var Meta */
    private $meta;

    /**
     * ResolvedListener constructor.
     * @param Listener $listener
     * @param Meta $meta
     */
    public function __construct(Listener $listener, Meta $meta)
    {
        $this->listener = $listener;
        $this->meta = $meta;
    }

    /**
     * @return Listener
     */
    public function getListener()
    {
        return $this->listener;
    }

    /**
     * @param $event
     * @return mixed
     */
    public function emit($event)
    {
        return $this->listener->handle($event, $this->meta);
    }
}
