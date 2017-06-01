<?php

namespace Simples\Console;

/**
 * Class RepositoryService
 * @package Simples\Console
 */
abstract class RepositoryService extends GeneratorService
{
    /**
     * @var string
     */
    protected static $layer = 'repository';

    /**
     * Ask for others layers
     * @param FileManager $fileManager
     */
    protected static function others(FileManager $fileManager, array &$parameters)
    {
        if (in_array(empty($parameters) ? read('Do you want to create Model layer?', '[y/n]') : array_shift($parameters), self::POSITIVES)) {
            $fileManager->execute('model');
        }
        if (in_array(empty($parameters) ? read('Do you want to create Repository layer?', '[y/n]') : array_shift($parameters), self::POSITIVES)) {
            $fileManager->execute('controller');
        }
    }
}
