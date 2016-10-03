<?php
/**
 * @package event
 */


namespace Mleko\Event\Tests\Listener;


class OneTimeListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOneTimeListener()
    {
        $emitter = new \Mleko\Event\SimpleEmitter(new \Mleko\Event\EventNameExtractor\ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Event\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Event\Listener::class)->getMockForAbstractClass();

        $subscription = $emitter->addListener('ArrayObject', new \Mleko\Event\Listener\OneTimeListener($listener));
        $this->assertNotNull($subscription);

        $event = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($event));

        $emitter->emit($event);
        $emitter->emit(new \ArrayObject());

        $this->assertFalse($subscription->unsubscribe());

    }
}
