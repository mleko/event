<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


class OneTimeListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOneTimeListener()
    {
        $eventBus = new \Mleko\Narrator\BasicEventBus(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $subscription = $eventBus->subscribe('ArrayObject', new \Mleko\Narrator\Listener\OneTimeListener($listener));
        $this->assertNotNull($subscription);

        $event = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($event));

        $eventBus->emit($event);
        $eventBus->emit(new \ArrayObject());

        $this->assertFalse($subscription->unsubscribe());

    }
}
