<?php
/**
 * @package event
 */


namespace Mleko\Event\Listener;


class CallableListener implements \Mleko\Event\Listener
{
    /** @var callable */
    private $callable;

    /**
     * CallableListener constructor.
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param object $event
     * @param \Mleko\Event\Meta $meta
     * @return mixed
     */
    public function handle($event, \Mleko\Event\Meta $meta)
    {
        return call_user_func_array($this->callable, [$event, $meta]);
    }
}
