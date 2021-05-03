<?php

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php'),
]);
return $aggregator->getMergedConfig();
//$configs = array_map(
//    function ($file) {
//       return require  $file;
//    },
//    glob(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE)
//);
//
//return array_merge_recursive(...$configs);
//return array_merge_recursive(
//    require __DIR__ . '/autoload/app.global.php',
//    require __DIR__ . '/autoload/auth.global.php',
//    require __DIR__ . '/autoload/auth.local.php',
//    require __DIR__ . '/autoload/app.local.php',
//    require __DIR__ . '/autoload/local.php'
//);
