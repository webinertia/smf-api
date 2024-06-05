<?php

declare(strict_types=1);

namespace Api;

require_once __DIR__ . '/../../../vendor/autoload.php';

// initialize the psr 11 container and run the app
(function() {
    /** @var \Psr\Container\ContainerInterface $container */
    $container = require __DIR__ . '/../../../config/container.php';
	$app = $container->get(App::class);
	$app->run();
})();