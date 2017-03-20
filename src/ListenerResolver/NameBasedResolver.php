<?php
/**
 * @package narrator
 */

namespace Mleko\Narrator\ListenerResolver;


use Mleko\Narrator\EventNameExtractor;
use Mleko\Narrator\EventSource;
use Mleko\Narrator\ListenerResolver;
use Mleko\Narrator\Meta;
use Mleko\Narrator\ResolvedListener;

class NameBasedResolver extends AbstractListenerResolver implements ListenerResolver
{

    /** @var EventNameExtractor */
    private $eventNameExtractor;

    /**
     * NameBasedResolver constructor.
     * @param EventNameExtractor $eventNameExtractor
     */
    public function __construct(EventNameExtractor $eventNameExtractor)
    {
        $this->eventNameExtractor = $eventNameExtractor;
    }

    /**
     * @param object $event
     * @param EventSource $eventSource
     * @return ResolvedListener[]
     */
    public function getEventListeners($event, EventSource $eventSource)
    {
        $eventName = $this->extractEventName($event);
        $eventListeners = array_key_exists($eventName, $this->listeners) ? $this->listeners[$eventName] : [];

        $eventMeta = new Meta($event, $eventName, $eventName, $eventSource);

        $resolvedListeners = [];
        foreach ($eventListeners as $listener) {
            $resolvedListeners[] = new ResolvedListener($listener, $eventMeta);
        }
        return $resolvedListeners;
    }

    /**
     * @param object $event
     * @return string
     */
    private function extractEventName($event)
    {
        return $this->eventNameExtractor->extract($event);
    }
}
