<?php

namespace Simples\Console;

use Simples\Kernel\App;

/**
 * Class HelpService
 * @package Simples\Console
 */
abstract class HelpService extends Service
{
    /**
     * @param App $app
     * @param array $parameters
     * @SuppressWarnings("unused")
     */
    public static function execute(App $app, array $parameters = [])
    {
        echo " # HELP\n";
        echo " Choose one option:\n";
        echo "    - route: show the routes\n";
        echo "    - model: service to manage models\n";
        echo "    - controller: service to manage controllers\n";
        echo "    - repository: service to manage repositories\n";
        echo "    - migration: create and run revisions\n";
        echo "\n";
        echo "    - exit: finish application\n";
    }
}
