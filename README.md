AsyncEventDispatcher  [![Build Status](https://api.travis-ci.org/Bodaclick/AsyncEventDispatcher.png?branch=master)](https://travis-ci.org/Bodaclick/AsyncEventDispatcher)
=====================

This lib is intended to allow for multiple "drivers" (a.k.a listeners) that publish
using a **fire and forget** strategy, mostly within pub/sub software.

The approach is inspired in Symfony's EventDispatcher component. However, the AsyncDispatcher 
registers the driver to **all** the events that have been registered (by adding a driver) if 
no event is passed, calling the driver for all of them.

## Installation ##
Install via composer.
Add to your current composer.json  ```require``` key: ```"bodaclick/async-event-dispatcher":"1.0.x-dev" ```

## Usage ##

You have to add drivers to the ```AsyncEventDispatcher``` so when an ```AsyncEventInterface``` is
fired it will be notified.

## Adding a Driver ##
```php

use BDK\AsyncEventDispatcher\AsyncEventDispatcher;
use BDK\AsyncEventDispatcher\AsyncDriver\RabbitMQDriver;

$driver = new RabbitMQDriver();
$ed = new AsyncEventDispatcher();

//Single event. It also registers the event
$ed->addDriver($driver, 'event.name');

//All events available
$ed->addDriver($driver);
```
## Firing the even ##

```php

use BDK\AsyncEventDispatcher\AsyncEventInterface;

$event = new CustomEvent(); //implements AsyncEventInterface
$ed->dispatch($event);
```

## Available drivers ##

Only two drivers are available
* RabbitMQ
* File

Feel free to PR with new drivers!

# Extension #

Creating a new driver is as easy as implementing the ``` AsyncEventDriverInterface ```

