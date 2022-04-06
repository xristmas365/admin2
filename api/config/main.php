<?php

$components = require __DIR__ . '/components.php';
$modules = require __DIR__ . '/modules.php';

return [
    'id'         => 'admin-nuxt',
    'name'       => 'Nuxt Admin Template',
    'basePath'   => dirname(__DIR__),
    'container'  => require __DIR__ . '/di.php',
    'components' => $components,
    'modules'    => $modules,
];
