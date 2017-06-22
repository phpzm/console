<?php

namespace Simples\Console;

use ReflectionClass;
use ReflectionMethod;

/**
 * Class MigratoryService
 * @package Simples\Console
 */
class MigratoryService extends Service
{
    /**
     * @param array $parameters
     * @SuppressWarnings("unused")
     */
    public static function execute(array &$parameters = [])
    {
        // TODO: Implement execute() method.
    }

    /**
     * @param string $class
     * @param string $method
     * @param string $line
     * @return bool
     */
    public static function addStatement(string $class, string $method, string $line): bool
    {
        $classReflection = new ReflectionClass($class);
        $fileName = $classReflection->getFileName();

        if (!empty($fileName)) {
            $classStartLine = 0;
            $classEndLine = $classReflection->getEndLine();
            $classLines = $classEndLine - $classStartLine;

            $classContent = array_slice(file($fileName), 0, $classLines);

            $methodReflection = new ReflectionMethod($class, $method);
            $methodEndLine = $methodReflection->getEndLine();

            $new = '        ' . $line . PHP_EOL;
            array_splice($classContent, $methodEndLine - $classStartLine - 1, 0, $new);

            return !!file_put_contents($fileName, implode("", $classContent));
        }
        return false;
    }
}
