<?php

namespace BDK\AsyncDispatcher\Tests\AsyncEventDispatcher;

use BDK\AsyncEventDispatcher\AsyncDriver\RabbitMQDriver;

class RabbitMQDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testDriver()
    {
        $producer = $this->getMockBuilder('OldSound\RabbitMqBundle\RabbitMq\Producer')
            ->disableOriginalConstructor()->getMock();
        $producer->expects($this->once())->method('publish')->will($this->returnValue(true));
        $serializer = $this->getMockBuilder('JMS\Serializer\Serializer')->disableOriginalConstructor()->getMock();
        $serializer->expects($this->once())->method('serialize')->will($this->returnValue('[]'));

        $driver = new RabbitMQDriver($producer, $serializer);
        $driver->setRoutingKey('test.core');
        $eventMock = $this->getMockForAbstractClass('BDK\AsyncEventDispatcher\AsyncEventInterface');
        $eventMock->expects($this->any())->method('getName')->will($this->returnValue('mock.event'));

        $this->assertEquals($eventMock, $driver->publish($eventMock));
        $this->assertEquals('test.core', $driver->getRoutingKey());
        $this->assertEquals('rabbitmq_async_driver', $driver->getName());
    }
}
