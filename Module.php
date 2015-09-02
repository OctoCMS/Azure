<?php

namespace Octo\GoogleAnalytics;

class Module extends \Octo\Module
{
    protected function getName()
    {
        return 'GoogleAnalytics';
    }

    protected function getPath()
    {
        return dirname(__FILE__) . '/';
    }
}
