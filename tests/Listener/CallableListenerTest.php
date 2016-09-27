<?php
/**
 * @package event
 */


namespace Mleko\Event\Tests\Listener;


class CallableListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testClosure()
    {
        $emitter = new \Mleko\Event\SimpleEmitter(new \Mleko\Event\EventNameExtractor\ClassNameExtractor());

        $eventToEmit = new \ArrayObject();

        $called = false;
        $emitter->addListener('ArrayObject', new \Mleko\Event\Listener\CallableListener(function ($event, \Mleko\Event\Meta $meta) use ($eventToEmit, &$called) {
            $this->assertSame($eventToEmit, $event);
            $called = true;
        }));

        $emitter->emit($eventToEmit);

        $this->assertTrue($called);
    }

    public function testObjectMethod()
    {
        $emitter = new \Mleko\Event\SimpleEmitter(new \Mleko\Event\EventNameExtractor\ClassNameExtractor());

        $mock = $this->getMockBuilder('stdClass')->setMethods(['method'])->getMock();
        $emitter->addListener('ArrayObject', new \Mleko\Event\Listener\CallableListener([$mock, 'method']));

        $eventToEmit = new \ArrayObject();
        $mock->expects($this->once())->method('method')->with($eventToEmit);

        $emitter->emit($eventToEmit);
    }
}
