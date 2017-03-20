<?php


namespace Mleko\Narrator\Tests\ListenerResolver;


use Mleko\Narrator\BasicEventBus;
use Mleko\Narrator\ListenerResolver\InstanceOfResolver;
use Mleko\Narrator\ResolvedListener;
use Mleko\Narrator\Tests\Listener\MockListener;
use PHPUnit\Framework\TestCase;

class InstanceOfResolverTest extends TestCase
{
    public function testResolving()
    {
        $resolver = new InstanceOfResolver();
        $bus = new BasicEventBus($resolver);

        $resolver->subscribe(Event::class, $l1 = new MockListener());
        $s2 = $resolver->subscribe(ParentEvent::class, $l2 = new MockListener());
        $resolver->subscribe(ChildEvent::class, $l3 = new MockListener());

        $resolvedListeners = $resolver->getEventListeners(new ParentEvent(), $bus);
        $this->assertEquals(2, count($resolvedListeners));
        $matchedListeners = array_map(function (ResolvedListener $r) {
            return $r->getListener();
        }, $resolvedListeners);
        $this->assertContains($l1, $matchedListeners);
        $this->assertContains($l2, $matchedListeners);

        $resolvedListeners = $resolver->getEventListeners(new ChildEvent(), $bus);
        $this->assertEquals(3, count($resolvedListeners));
        $matchedListeners = array_map(function (ResolvedListener $r) {
            return $r->getListener();
        }, $resolvedListeners);
        $this->assertContains($l1, $matchedListeners);
        $this->assertContains($l2, $matchedListeners);
        $this->assertContains($l3, $matchedListeners);

        $this->assertTrue($s2->unsubscribe());
        $resolvedListeners = $resolver->getEventListeners(new ChildEvent(), $bus);
        $this->assertEquals(2, count($resolvedListeners));
        $matchedListeners = array_map(function (ResolvedListener $r) {
            return $r->getListener();
        }, $resolvedListeners);
        $this->assertContains($l1, $matchedListeners);
        $this->assertContains($l3, $matchedListeners);
    }
}

interface Event
{
}

class ParentEvent implements Event
{
}

class ChildEvent extends ParentEvent
{

}
