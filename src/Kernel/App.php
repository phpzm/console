<?php

namespace Simples\Console\Kernel;

use function is_array;
use Simples\Console\HelpService;
use Simples\Console\Service;
use Simples\Kernel\App as Kernel;

/**
 * Class Console
 * @package Simples\Kernel
 */
class App
{
    /**
     * @var array
     */
    private static $services = [];

    /**
     * @var string
     */
    private static $otherWise = '';

    /**
     *
     */
    protected static function boot()
    {
        $services = Kernel::config('console.services');

        if (!is_array($services)) {
            $services = [];
        }

        foreach ($services as $index => $service) {
            static::register($index, function ($parameters) use ($service) {
                /** @var Service $service */
                $service::execute($parameters);
            });
        }

        static::register('help', function ($parameters) {
            HelpService::execute($parameters);
        });
        static::otherWise('help');
    }

    /**
     * @param array $parameters
     */
    public static function handle(array $parameters)
    {
        static::boot();

        echo "@start/\n";
        echo "Press ^C or type 'exit' at any time to quit.\n";

        $service = off(array_values($parameters), 0, static::$otherWise);
        array_shift($parameters);

        do {
            static::execute($service, $parameters);
            $service = empty($parameters) ? read() : array_shift($parameters);
        } while (!in_array($service, Service::KILLERS));
    }

    /**
     * @param string $id
     * @param callable $callable
     */
    private static function register(string $id, callable $callable)
    {
        static::$services[$id] = $callable;
    }

    /**
     * @param string $service
     * @param array $parameters
     */
    private static function execute(string $service, array &$parameters)
    {
        if (isset(static::$services[$service])) {
            call_user_func_array(static::$services[$service], [$parameters]);
        }
    }

    /**
     * @param $otherWise
     */
    private static function otherWise($otherWise)
    {
        static::$otherWise = $otherWise;
    }
}
