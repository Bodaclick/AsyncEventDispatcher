<?php

namespace BDK\AsyncEventDispatcher;

/**
 * AsyncEventDispatcher
 *
 * @copyright Bodaclick S.A
 * @author Eduardo Gulias Davis <eduardo.gulias@bodaclick.com>
 */
class AsyncEventDispatcher implements AsyncEventDispatcherInterface
{
    /**
     * events
     *
     * @var array
     */
    private $events = [];

    /**
     * drivers
     *
     * @var driver
     */
    private $drivers = [];

    /**
     * {@inherit}
     */
    public function dispatch(AsyncEventInterface $event)
    {
        if (!isset($this->events[$event->getName()])) {
            return $event;
        }

        foreach ($this->events[$event->getName()] as $driver) {
            $driver->publish($event);
        }

        return $event;
    }

    /**
     * {@inherit}
     */
    public function addDriver(AsyncEventDriverInterface $driver, $eventName = null)
    {
        $this->drivers[$driver->getName()] = $driver;
        if (null === $eventName) {
            foreach ($this->events as $name => $currentDriver) {
                $this->events[$name][$driver->getName()] = $driver;
            }
        }

        if (!isset($this->events[$eventName][$driver->getName()])) {
            $this->events[$eventName][$driver->getName()] = $driver;
        }
    }

    /**
     * {@inherit}
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * {@inherit}
     */
    public function removeDriver(AsyncEventDriverInterface $driver, $eventName = null)
    {
        unset($this->drivers[$driver->getName()]);
        if (null === $eventName) {
            foreach ($this->events as $eventName => $currentDriver) {
                unset($this->events[$eventName][$driver->getName()]);
            }
        }
        unset($this->events[$eventName][$driver->getName()]);
    }

    /**
     * {@inherit}
     */
    public function hasDriver($driverName)
    {
        return isset($this->drivers[$driverName]);
    }

    /**
     * eventHasDrivers
     *
     * @param string $eventName
     *
     * @return Boolean
     */
    public function eventHasDrivers($eventName)
    {
        return (bool) count($this->events[$eventName]);
    }
    
    /**
     * get the registerd events
     * 
     * @return array of events
     */
    public function getEvents()
    {
        return $this->events;
    }
}
