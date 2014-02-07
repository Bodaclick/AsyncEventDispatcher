<?php

namespace BDK\AsyncDispatcher\Tests\AsyncEventDispatcher;

use BDK\AsyncEventDispatcher\AsyncEventDispatcher;

class AsyncEventDispatcherFunctionalTest extends \PHPUnit_Framework_TestCase
{
    public function testFunctionalDispatch()
    {
        $driverStub = $this->getMockForAbstractclass('BDK\AsyncEventDispatcher\AsyncEventDriverInterface');
        $driverStub->expects($this->once())->method('publish')->will($this->returnValue(true));
        $eventMock = $this->getMockForAbstractClass('BDK\AsyncEventDispatcher\AsyncEventInterface');
        $eventMock->expects($this->any())->method('getName')->will($this->returnValue('mock.event'));
        $eventMock->expects($this->any())->method('getDriver')->will($this->returnValue($driverStub));

        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($driverStub, $eventMock->getName());
        $this->assertEquals($eventMock, $dispatcher->dispatch($eventMock));
    }
}
