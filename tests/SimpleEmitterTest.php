<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests;


class SimpleEmitterTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitterMutation()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $this->assertFalse($emitter->unsubscribe('ArrayObject', $listener));

        $subscription = $emitter->subscribe('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($eventToEmit), $this->callback(function (\Mleko\Narrator\Meta $meta) use ($emitter, $eventToEmit) {
                $this->assertSame($emitter, $meta->getEventSource());
                $this->assertEquals('ArrayObject', $meta->getEventName());
                $this->assertEquals('ArrayObject', $meta->getMatchedName());
                $this->assertEquals($eventToEmit, $meta->getEvent());
                return true;
            }));

        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->unsubscribe('Iterator', $listener));
        $this->assertTrue($emitter->unsubscribe('ArrayObject', $listener));

        $emitter->emit($eventToEmit);

        $this->assertFalse($emitter->unsubscribe('ArrayObject', $listener));
    }

    public function testSubscription()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();
        $subscription = $emitter->subscribe('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($eventToEmit));

        $emitter->emit($eventToEmit);

        $subscription->unsubscribe();

        $emitter->emit($eventToEmit);
    }

    public function testConstructor()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $emitter = new \Mleko\Narrator\SimpleEmitter(
            new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor(),
            [
                'ArrayObject' => [$listener],
                'Exception' => [$listener]
            ]
        );

        $this->assertTrue($emitter->unsubscribe('Exception', $listener));
    }
}
