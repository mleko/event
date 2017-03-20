<?php


namespace Mleko\Narrator\Tests\Listener;


use Mleko\Narrator\Listener;
use Mleko\Narrator\Meta;

class MockListener implements Listener
{

    /**
     * Handle an event
     *
     * @param object $event
     * @param Meta $meta
     */
    public function handle($event, Meta $meta)
    {
    }
}
