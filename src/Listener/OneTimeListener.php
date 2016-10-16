<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Listener;


class OneTimeListener implements \Mleko\Narrator\Listener
{
    /** @var \Mleko\Narrator\Listener */
    private $wrappedListener;

    /** @var bool */
    private $fired = false;

    /**
     * OneTimeListener constructor.
     * @param \Mleko\Narrator\Listener $listener
     */
    public function __construct(\Mleko\Narrator\Listener $listener)
    {
        $this->wrappedListener = $listener;
    }

    public function handle($event, \Mleko\Narrator\Meta $meta)
    {
        if (!$this->fired) {
            $this->fired = true;
            $this->unsubscribe($meta);
            $this->wrappedListener->handle($event, $meta);
        }
    }

    private function unsubscribe(\Mleko\Narrator\Meta $meta)
    {
        $emitter = $meta->getEmitter();
        if ($emitter instanceof \Mleko\Narrator\MutableEmitter) {
            $emitter->removeListener($meta->getMatchedName(), $this);
        }
    }


}
