<?php

namespace Octo\Azure;

class Module extends \Octo\Module
{
    protected function getName()
    {
        return 'Azure';
    }

    protected function getPath()
    {
        return dirname(__FILE__) . '/';
    }
}
