<?php


namespace Mleko\Narrator\ListenerResolver;


use Mleko\Narrator\EventSource;
use Mleko\Narrator\ListenerResolver;
use Mleko\Narrator\Meta;
use Mleko\Narrator\ResolvedListener;

class InstanceOfResolver extends AbstractListenerResolver implements ListenerResolver
{

    /**
     * @param object $event
     * @param EventSource $eventSource
     * @return ResolvedListener[]
     */
    public function getEventListeners($event, EventSource $eventSource)
    {
        $eventName = get_class($event);
        $resolvedListeners = [];
        foreach ($this->listeners as $matchedName => $listeners) {
            if (!is_a($event, $matchedName, true)) {
                break;
            }
            $eventMeta = new Meta($event, $eventName, $matchedName, $eventSource);
            foreach ($listeners as $listener) {
                $resolvedListeners[] = new ResolvedListener($listener, $eventMeta);

            }
        }
        return $resolvedListeners;
    }
}
