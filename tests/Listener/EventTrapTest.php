<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


class EventTrapTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleEvents()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $emitter->subscribe('ArrayObject', $trap = new \Mleko\Narrator\Listener\EventTrap(false));

        $emitter->emit($event1 = new \ArrayObject());
        $emitter->emit($event2 = new \ArrayObject());

        $this->assertEquals(2, count($trap->getTrappedEvents()));
        $this->assertContains($event1, $trap->getTrappedEvents());
        $this->assertContains($event2, $trap->getTrappedEvents());
    }

    public function testOneTimeTrap()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $emitter->subscribe('ArrayObject', $trap = new \Mleko\Narrator\Listener\EventTrap());

        $emitter->emit($event1 = new \ArrayObject());
        $emitter->emit($event2 = new \ArrayObject());

        $this->assertEquals(1, count($trap->getTrappedEvents()));
        $this->assertContains($event1, $trap->getTrappedEvents());
        $this->assertSame($event1, $trap->getFirstEvent());
    }
}
