<?php

namespace Octo\Azure\Event;

use b8\Config;
use Octo\Admin\Template;
use Octo\Event\Listener;
use Octo\Event\Manager;

class FileEvents extends Listener
{
    public function registerListeners(Manager $manager)
    {
        $manager->registerListener('GetFile', array($this, 'getFile'));
        $manager->registerListener('PutFile', array($this, 'putFile'));
    }

    public function getFile(array &$file)
    {

    }

    public function putFile(array &$file)
    {

    }
}
