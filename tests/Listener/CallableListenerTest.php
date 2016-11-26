<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


class CallableListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testClosure()
    {
        $eventBus = new \Mleko\Narrator\BasicEventBus(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $eventToEmit = new \ArrayObject();

        $called = false;
        $eventBus->subscribe('ArrayObject', new \Mleko\Narrator\Listener\CallableListener(function ($event, \Mleko\Narrator\Meta $meta) use ($eventToEmit, &$called) {
            $this->assertSame($eventToEmit, $event);
            $called = true;
        }));

        $eventBus->emit($eventToEmit);

        $this->assertTrue($called);
    }

    public function testObjectMethod()
    {
        $eventBus = new \Mleko\Narrator\BasicEventBus(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $mock = $this->getMockBuilder('stdClass')->setMethods(['method'])->getMock();
        $eventBus->subscribe('ArrayObject', new \Mleko\Narrator\Listener\CallableListener([$mock, 'method']));

        $eventToEmit = new \ArrayObject();
        $mock->expects($this->once())->method('method')->with($eventToEmit);

        $eventBus->emit($eventToEmit);
    }
}
