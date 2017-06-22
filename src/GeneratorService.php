<?php

namespace Simples\Console;

use Simples\Kernel\App;

/**
 * Class GeneratorService
 * @package Simples\Console
 */
abstract class GeneratorService extends Service
{
    /**
     * @var array
     */
    const POSITIVES = ['y', 'yes', 'yep'];

    /**
     * @var string
     */
    protected static $layer = '';

    /**
     * @param array $parameters
     * @SuppressWarnings("unused")
     */
    public static function execute(array &$parameters = [])
    {
        $option = (empty($parameters)) ? '' : array_shift($parameters);
        do {
            switch ($option) {
                case 'create':
                    $commands = self::create($parameters);

                    $replacements = [
                        'namespace' => [
                            'field' => '${NAMESPACE}',
                            'value' => App::config('app.namespace') . $commands['namespace']
                        ],
                        'name' => [
                            'field' => '${NAME}',
                            'value' => $commands['name']
                        ]
                    ];
                    $fileManager = new FileManager($commands['namespace'], $commands['name'], $replacements);

                    $fileManager->execute(static::$layer);

                    static::others($fileManager, $parameters);
                    break;
            }


            echo " # MODEL\n";
            echo " Choose one option:\n";
            echo "    - create\n";
            // echo "    - refactor\n";
            // echo "    - remove\n";

            $option = empty($parameters) ? read('[ ' . static::$layer . ' ]$ ') : array_shift($parameters);
        } while (!in_array($option, Service::KILLERS));
    }

    /**
     * @param array $parameters
     * @return array|null
     */
    protected static function create(array &$parameters)
    {
        $control = 'action';
        $option = empty($parameters) ? '' : array_shift($parameters);
        $message = '';
        $commands = [];
        do {
            switch ($control) {
                case 'action':
                    $commands['action'] = '';
                    $message = ' namespace: $ [' . App::config('app.namespace') . ']';
                    $control = 'namespace';
                    break;
                case 'namespace':
                    $commands['namespace'] = $option;
                    $message = ' name: $ ';
                    $control = 'name';
                    $option = '';
                    break;
                case 'name':
                    $commands['name'] = $option;
                    $option = '';
                    return $commands;
                    break;
            }
            if(empty($option)){
                $option = empty($parameters) ? read("[ " . static::$layer .  ".create ]{$message}") : array_shift($parameters);
            }
        } while (!in_array($option, Service::KILLERS));

        return null;
    }

    /**
     * @param $parameters
     * @param string $prompt
     * @param string $options
     * @return mixed|string
     */
    protected static function explain($parameters, string $prompt, string $options = '')
    {
        return empty($parameters) ? read($prompt, $options) : array_shift($parameters);
    }

    /**
     * Ask for others layers
     * @param FileManager $fileManager
     * @throws \Exception
     */
    abstract protected static function others(FileManager $fileManager, array &$parameters);
}
