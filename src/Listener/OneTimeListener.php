<?php
/**
 * @package event
 */


namespace Mleko\Event\Listener;


class OneTimeListener implements \Mleko\Event\Listener
{
    /** @var \Mleko\Event\Listener */
    private $wrappedListener;

    /** @var bool */
    private $fired = false;

    /**
     * OneTimeListener constructor.
     * @param \Mleko\Event\Listener $listener
     */
    public function __construct(\Mleko\Event\Listener $listener)
    {
        $this->wrappedListener = $listener;
    }

    public function handle($event, \Mleko\Event\Meta $meta)
    {
        if (!$this->fired) {
            $this->fired = true;
            $this->unsubscribe($meta);
            $this->wrappedListener->handle($event, $meta);
        }
    }

    private function unsubscribe(\Mleko\Event\Meta $meta)
    {
        $emitter = $meta->getEmitter();
        if ($emitter instanceof \Mleko\Event\MutableEmitter) {
            $emitter->removeListener($meta->getMatchedName(), $this);
        }
    }


}
