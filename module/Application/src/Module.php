<?php

namespace Application;

/**
 * Class Module
 * @package Application
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
