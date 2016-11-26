<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


use Mleko\Narrator\BasicEventBus;
use Mleko\Narrator\EventNameExtractor\ClassNameExtractor;
use Mleko\Narrator\Listener\EventTrap;

class EventTrapTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleEvents()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        $eventBus->subscribe('ArrayObject', $trap = new EventTrap(false));

        $eventBus->emit($event1 = new \ArrayObject());
        $eventBus->emit($event2 = new \ArrayObject());

        $this->assertEquals(2, count($trap->getTrappedEvents()));
        $this->assertContains($event1, $trap->getTrappedEvents());
        $this->assertContains($event2, $trap->getTrappedEvents());
    }

    public function testOneTimeTrap()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        $eventBus->subscribe('ArrayObject', $trap = new EventTrap());

        $eventBus->emit($event1 = new \ArrayObject());
        $eventBus->emit($event2 = new \ArrayObject());

        $this->assertEquals(1, count($trap->getTrappedEvents()));
        $this->assertContains($event1, $trap->getTrappedEvents());
        $this->assertSame($event1, $trap->getFirstEvent());
    }

    public function testOneTimeTrapReRegistered()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        $eventBus->subscribe('ArrayObject', $trap = new EventTrap());
        $eventBus->subscribe('ArrayObject', $trap);

        $eventBus->emit($event1 = new \ArrayObject());
        $eventBus->emit($event2 = new \ArrayObject());

        $this->assertEquals(1, count($trap->getTrappedEvents()));
        $this->assertContains($event1, $trap->getTrappedEvents());
        $this->assertSame($event1, $trap->getFirstEvent());

        $this->assertFalse($eventBus->unsubscribe('ArrayObject', $trap));
    }
}
