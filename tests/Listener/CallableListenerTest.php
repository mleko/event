<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


use Mleko\Narrator\BasicEventBus;
use Mleko\Narrator\EventNameExtractor\ClassNameExtractor;
use Mleko\Narrator\Listener\CallableListener;
use Mleko\Narrator\Meta;

class CallableListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testClosure()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        $eventToEmit = new \ArrayObject();

        $called = false;
        $eventBus->subscribe('ArrayObject', new CallableListener(function ($event, Meta $meta) use ($eventToEmit, &$called) {
            $this->assertSame($eventToEmit, $event);
            $called = true;
        }));

        $eventBus->emit($eventToEmit);

        $this->assertTrue($called);
    }

    public function testObjectMethod()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        $mock = $this->getMockBuilder('stdClass')->setMethods(['method'])->getMock();
        $eventBus->subscribe('ArrayObject', new CallableListener([$mock, 'method']));

        $eventToEmit = new \ArrayObject();
        $mock->expects($this->once())->method('method')->with($eventToEmit);

        $eventBus->emit($eventToEmit);
    }
}
