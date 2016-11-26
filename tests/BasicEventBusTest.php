<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests;


class BasicEventBusTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitterMutation()
    {
        $eventBus = new \Mleko\Narrator\BasicEventBus(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $this->assertFalse($eventBus->unsubscribe('ArrayObject', $listener));

        $subscription = $eventBus->subscribe('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($eventToEmit), $this->callback(function (\Mleko\Narrator\Meta $meta) use ($eventBus, $eventToEmit) {
                $this->assertSame($eventBus, $meta->getEventSource());
                $this->assertEquals('ArrayObject', $meta->getEventName());
                $this->assertEquals('ArrayObject', $meta->getMatchedName());
                $this->assertEquals($eventToEmit, $meta->getEvent());
                return true;
            }));

        $eventBus->emit($eventToEmit);

        $this->assertFalse($eventBus->unsubscribe('Iterator', $listener));
        $this->assertTrue($eventBus->unsubscribe('ArrayObject', $listener));

        $eventBus->emit($eventToEmit);

        $this->assertFalse($eventBus->unsubscribe('ArrayObject', $listener));
    }

    public function testSubscription()
    {
        $eventBus = new \Mleko\Narrator\BasicEventBus(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();
        $subscription = $eventBus->subscribe('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($eventToEmit));

        $eventBus->emit($eventToEmit);

        $subscription->unsubscribe();

        $eventBus->emit($eventToEmit);
    }

    public function testConstructor()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|\Mleko\Narrator\Listener $listener */
        $listener = $this->getMockBuilder(\Mleko\Narrator\Listener::class)->getMockForAbstractClass();

        $eventBus = new \Mleko\Narrator\BasicEventBus(
            new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor(),
            [
                'ArrayObject' => [$listener],
                'Exception'   => [$listener]
            ]
        );

        $this->assertTrue($eventBus->unsubscribe('Exception', $listener));
    }
}
