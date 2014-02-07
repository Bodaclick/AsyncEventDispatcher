<?php

namespace BDK\AsyncEventDispatcher;

/**
 * AsyncEventDispatcherInterface
 *
 * @copyright Bodaclick S.A
 * @author Eduardo Gulias Davis <eduardo.gulias@bodaclick.com>
 */
interface AsyncEventDispatcherInterface
{
    /**
     * dispatch
     *
     * @param AsyncEventInterface $event
     *
     */
    public function dispatch(AsyncEventInterface $event);

    /**
     * addDriver
     *
     * @param AsyncEventDriverInterface $driver
     * @param string                    $eventName
     *
     * @return void
     */
    public function addDriver(AsyncEventDriverInterface $driver, $eventName = null);

    /**
     * getDrivers
     *
     * @return array
     */
    public function getDrivers();

    /**
     * removeDriver
     *
     * @param AsyncEventDriverInterface $driver
     * @param string                    $eventName
     *
     */
    public function removeDriver(AsyncEventDriverInterface $driver, $eventName);

    /**
     * hasDriver
     *
     * @param string $driverName
     *
     * @return boolean
     */
    public function hasDriver($driverName);
}
