<?php

namespace Simples\Console\Kernel;

use Simples\Console\HelpService;
use Simples\Console\Service;

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
//        static::register('route', function ($app, $parameters) {
//            RouteService::execute($app, $parameters);
//        });
//        static::register('model', function ($app, $parameters) {
//            ModelService::execute($app, $parameters);
//        });
//        static::register('controller', function ($app, $parameters) {
//            ControllerService::execute($app, $parameters);
//        });
//        static::register('repository', function ($app, $parameters) {
//            RepositoryService::execute($app, $parameters);
//        });
        static::register('help', function ($parameters) {
            HelpService::execute($parameters);
        });
        static::otherWise('help');
    }

    /**
     * @param array $parameters
     */
    public static function handler(array $parameters)
    {
        static::boot();

        echo "@start/\n";
        echo "Press ^C or type 'exit' at any time to quit.\n";

        $service = off($parameters, 0, static::$otherWise);
        array_shift($parameters);
        do {
            static::execute($service, $parameters);
            $service = read();
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
    private static function execute(string $service, array $parameters)
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
