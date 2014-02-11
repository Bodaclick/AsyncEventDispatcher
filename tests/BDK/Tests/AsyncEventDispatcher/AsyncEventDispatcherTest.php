<?php

namespace BDK\AsyncDispatcherBundle\Tests\Model\EventDispatcher;

use BDK\AsyncEventDispatcher\AsyncEventDispatcher;

class AsyncEventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    protected $driverMock;

    public function setUp()
    {
        $this->driverMock = $this->getMockForAbstractClass('BDK\AsyncEventDispatcher\AsyncEventDriverInterface');
        $this->driverMock->expects($this->any())->method('getName')->will($this->returnValue('mock.driver'));
    }

    public function tearDown()
    {
        $this->driverMock = null;
    }

    public function testDisptacherInterface()
    {
        $dispatcher = new AsyncEventDispatcher();

        $this->assertInstanceOf('BDK\AsyncEventDispatcher\AsyncEventDispatcherInterface', $dispatcher);
    }

    public function testAddDrivers()
    {
        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock, 'mock.event');

        $this->assertInternalType('array', $dispatcher->getDrivers());
        $this->assertCount(1, $dispatcher->getDrivers());
        $this->assertEquals($this->driverMock, $dispatcher->getDrivers()['mock.driver']);
    }

    public function testAddDriverNullEvent()
    {
        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock);

        $this->assertInternalType('array', $dispatcher->getDrivers());
        $this->assertCount(1, $dispatcher->getDrivers());
        $this->assertEquals($this->driverMock, $dispatcher->getDrivers()['mock.driver']);
    }

    public function testRemoveDrivers()
    {
        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock);
        $dispatcher->removeDriver($this->driverMock);

        $this->assertCount(0, $dispatcher->getDrivers());
    }

    public function testDispatch()
    {
        $this->driverMock->expects($this->any())->method('publish')->will($this->returnValue(true));
        $eventMock = $this->getMockForAbstractClass('BDK\AsyncEventDispatcher\AsyncEventInterface');
        $eventMock->expects($this->any())->method('getName')->will($this->returnValue('mock.event'));

        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock, $eventMock->getName());
        $this->assertEquals($eventMock, $dispatcher->dispatch($eventMock));
    }

    public function testHasDriver()
    {
        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock);

        $this->assertTrue($dispatcher->hasDriver('mock.driver'));
    }

    public function testHasNotDriver()
    {
        $dispatcher = new AsyncEventDispatcher();

        $this->assertFalse($dispatcher->hasDriver('mock.driver'));
    }
    
    public function testGetEvents()
    {
        $dispatcher = new AsyncEventDispatcher();
        $dispatcher->addDriver($this->driverMock, 'testName');
        $this->assertCount(1, $dispatcher->getEvents());
    }
}
