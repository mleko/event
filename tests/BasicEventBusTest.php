<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests;


use Mleko\Narrator\BasicEventBus;
use Mleko\Narrator\EventNameExtractor\ClassNameExtractor;
use Mleko\Narrator\Listener;
use Mleko\Narrator\ListenerResolver\NameBasedResolver;
use Mleko\Narrator\Meta;

class BasicEventBusTest extends \PHPUnit\Framework\TestCase
{
    public function testEmitterMutation()
    {
        $eventBus = new BasicEventBus(new NameBasedResolver(new ClassNameExtractor()));
        /** @var \PHPUnit_Framework_MockObject_MockObject|Listener $listener */
        $listener = $this->getMockBuilder(Listener::class)->getMockForAbstractClass();

        $this->assertFalse($eventBus->unsubscribe('ArrayObject', $listener));

        $subscription = $eventBus->subscribe('ArrayObject', $listener);
        $this->assertNotNull($subscription);

        $eventToEmit = new \ArrayObject();
        $listener->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($eventToEmit), $this->callback(function (Meta $meta) use ($eventBus, $eventToEmit) {
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
        $eventBus = new BasicEventBus(new NameBasedResolver(new ClassNameExtractor()));

        /** @var \PHPUnit_Framework_MockObject_MockObject|Listener $listener */
        $listener = $this->getMockBuilder(Listener::class)->getMockForAbstractClass();
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
        /** @var \PHPUnit_Framework_MockObject_MockObject|Listener $listener */
        $listener = $this->getMockBuilder(Listener::class)->getMockForAbstractClass();

        $eventBus = new BasicEventBus(
            new NameBasedResolver(new ClassNameExtractor()),
            [
                'ArrayObject' => [$listener],
                'Exception' => [$listener]
            ]
        );

        $this->assertTrue($eventBus->unsubscribe('Exception', $listener));
    }
}
