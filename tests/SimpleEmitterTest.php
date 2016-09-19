<?php
/**
 * @package events
 */


namespace Mleko\Events\Tests;


class SimpleEmitterTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitterMutation()
    {
        $emitter = new \Mleko\Events\SimpleEmitter(new \Mleko\Events\EventNameExtractor\ClassNameExtractor());
        $listener = $this->getMockBuilder(\Mleko\Events\Listener::class)->getMockForAbstractClass();

        $this->assertFalse($emitter->removeListener('ArrayObject', $listener));

        $subscription = $emitter->addListener('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($eventToEmit));
        
        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->removeListener('Iterator', $listener));
        $this->assertTrue($emitter->removeListener('ArrayObject', $listener));

        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->removeListener('ArrayObject', $listener));
    }

    public function testSubscription()
    {
        $emitter = new \Mleko\Events\SimpleEmitter(new \Mleko\Events\EventNameExtractor\ClassNameExtractor());
        $listener = $this->getMockBuilder(\Mleko\Events\Listener::class)->getMockForAbstractClass();
        $subscription = $emitter->addListener('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($eventToEmit));

        $emitter->emit($eventToEmit);

        $subscription->unsubscribe();

        $emitter->emit($eventToEmit);
    }
}
