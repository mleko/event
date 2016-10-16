<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


class OneTimeListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOneTimeListener()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $subscription = $emitter->addListener('ArrayObject', new \Mleko\Narrator\Listener\OneTimeListener($listener));
        $this->assertNotNull($subscription);

        $event = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($event));

        $emitter->emit($event);
        $emitter->emit(new \ArrayObject());

        $this->assertFalse($subscription->unsubscribe());

    }
}
