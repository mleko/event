<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Listener;


class CallableListener implements \Mleko\Narrator\Listener
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
     * @param \Mleko\Narrator\Meta $meta
     * @return mixed
     */
    public function handle($event, \Mleko\Narrator\Meta $meta)
    {
        return call_user_func_array($this->callable, [$event, $meta]);
    }
}
