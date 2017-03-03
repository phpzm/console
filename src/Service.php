<?php

namespace Simples\Console;

/**
 * Class Service
 * @package Simples\Console
 */
abstract class Service
{
    /**
     * @var array
     */
    const KILLERS = ['exit', 'q', 'quit', 'bye'];

    /**
     * @param array $parameters
     */
    abstract public static function execute(array $parameters = []);
}
