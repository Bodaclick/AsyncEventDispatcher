<?php


namespace BDK\AsyncDispatcher\AsyncEventDispatcher\AsyncDriver;

use BDK\AsyncDispatcher\AsyncEventDispatcher\AsyncEventDriverInterface;
use BDK\AsyncDispatcher\AsyncEventDispatcher\AsyncEventInterface;

/**
 * Class FileDriver
 * @author Eduardo Gulias Davis <eduardo.gulias@bodaclick.com>
@copyright 2014 Bodaclick */
class FileDriver implements AsyncEventDriverInterface
{
    public function getName()
    {
        return 'file.driver';
    }

    public function publish(AsyncEventInterface $event)
    {
        $fh = fopen(__DIR__ . DIRECTORY_SEPARATOR . $this->getName() . '.published', 'w');
        fclose($fh);
    }

} 