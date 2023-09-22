<?php

use Composer\XdebugHandler\XdebugHandler;
use Ilyaplot\Architect\Application;

if (PHP_VERSION_ID < 80100) {
    echo 'Required at least PHP version 8.1.0, your version: ' . PHP_VERSION . PHP_EOL;
    exit(1);
}

(static function (): void {
    if (file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
        require_once $autoload;
    }
})();

(static function (): void {
    if (file_exists($autoload = getcwd() . '/vendor/autoload.php')) {
        include_once $autoload;
    }
})();

$xdebug = new XdebugHandler('ARCHITECT');
$xdebug->check();
unset($xdebug);

(new Application())->run();
