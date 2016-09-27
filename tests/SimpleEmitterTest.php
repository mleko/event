<?php
/**
 * @package event
 */


namespace Mleko\Event\Tests;


class SimpleEmitterTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitterMutation()
    {
        $emitter = new \Mleko\Event\SimpleEmitter(new \Mleko\Event\EventNameExtractor\ClassNameExtractor());
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Event\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Event\Listener::class)->getMockForAbstractClass();

        $this->assertFalse($emitter->removeListener('ArrayObject', $listener));

        $subscription = $emitter->addListener('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($eventToEmit), $this->callback(function (\Mleko\Event\Meta $meta) use ($emitter, $eventToEmit) {
                $this->assertSame($emitter, $meta->getEmitter());
                $this->assertEquals('ArrayObject', $meta->getEventName());
                $this->assertEquals('ArrayObject', $meta->getMatchedName());
                $this->assertEquals($eventToEmit, $meta->getEvent());
                return true;
            }));

        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->removeListener('Iterator', $listener));
        $this->assertTrue($emitter->removeListener('ArrayObject', $listener));

        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->removeListener('ArrayObject', $listener));
    }

    public function testSubscription()
    {
        $emitter = new \Mleko\Event\SimpleEmitter(new \Mleko\Event\EventNameExtractor\ClassNameExtractor());
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Event\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Event\Listener::class)->getMockForAbstractClass();
        $subscription = $emitter->addListener('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($eventToEmit));

        $emitter->emit($eventToEmit);

        $subscription->unsubscribe();

        $emitter->emit($eventToEmit);
    }
}
