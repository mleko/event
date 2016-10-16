<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


class CallableListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testClosure()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $eventToEmit = new \ArrayObject();

        $called = false;
        $emitter->addListener('ArrayObject', new \Mleko\Narrator\Listener\CallableListener(function ($event, \Mleko\Narrator\Meta $meta) use ($eventToEmit, &$called) {
            $this->assertSame($eventToEmit, $event);
            $called = true;
        }));

        $emitter->emit($eventToEmit);

        $this->assertTrue($called);
    }

    public function testObjectMethod()
    {
        $emitter = new \Mleko\Narrator\SimpleEmitter(new \Mleko\Narrator\EventNameExtractor\ClassNameExtractor());

        $mock = $this->getMockBuilder('stdClass')->setMethods(['method'])->getMock();
        $emitter->addListener('ArrayObject', new \Mleko\Narrator\Listener\CallableListener([$mock, 'method']));

        $eventToEmit = new \ArrayObject();
        $mock->expects($this->once())->method('method')->with($eventToEmit);

        $emitter->emit($eventToEmit);
    }
}
