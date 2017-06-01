<?php

namespace Simples\Console;

/**
 * Class ModelService
 * @package Simples\Console
 */
abstract class ModelService extends GeneratorService
{
    /**
     * @var string
     */
    protected static $layer = 'model';

    /**
     * Ask for others layers
     * @param FileManager $fileManager
     */
    protected static function others(FileManager $fileManager, array &$parameters)
    {
        if (in_array(empty($parameters) ? read('Do you want to create Model layer?', '[y/n]') : array_shift($parameters), self::POSITIVES)) {
            $fileManager->execute('controller');
        }
        if (in_array(empty($parameters) ? read('Do you want to create Repository layer?', '[y/n]') : array_shift($parameters), self::POSITIVES)) {
            $fileManager->execute('repository');
        }
    }
}
