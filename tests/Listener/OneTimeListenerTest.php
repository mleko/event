<?php
/**
 * @package narrator
 */


namespace Mleko\Narrator\Tests\Listener;


use Mleko\Narrator\BasicEventBus;
use Mleko\Narrator\EventNameExtractor\ClassNameExtractor;
use Mleko\Narrator\Listener;
use Mleko\Narrator\Listener\OneTimeListener;

class OneTimeListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOneTimeListener()
    {
        $eventBus = new BasicEventBus(new ClassNameExtractor());

        /** @var \PHPUnit_Framework_MockObject_MockObject|Listener $listener */
        $listener = $this->getMockBuilder(Listener::class)->getMockForAbstractClass();

        $subscription = $eventBus->subscribe('ArrayObject', new OneTimeListener($listener));
        $this->assertNotNull($subscription);

        $event = new \ArrayObject();
        $listener->expects($this->once())->method('handle')->with($this->equalTo($event));

        $eventBus->emit($event);
        $eventBus->emit(new \ArrayObject());

        $this->assertFalse($subscription->unsubscribe());

    }
}
