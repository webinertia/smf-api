<?php

declare(strict_types=1);

namespace Api;

// chdir(dirname(__DIR__));
// composer autoloader
// require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../vendor/autoload.php';
// Setup Env

(function() {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require __DIR__ . '/../../../config/container.php';
	$app = $container->get(App::class);
	$app->run();
})();