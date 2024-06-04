<?php

declare(strict_types=1);

namespace Api\Service;

use Api\App;
use Api\Event\Listener\ApiListener;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;
use Psr\Container\ContainerInterface;

if (! defined('SMF')) {
	die('No direct access...');
}

final class AppFactory
{
	public function __invoke(ContainerInterface $container): App
	{
		$eventManager = $container->get(EventManagerInterface::class);
		$eventManager->setIdentifiers([App::class]);
		/** @var ApiListener */
		$listener = $container->get(ApiListener::class);
		$listener->attach($eventManager);
		$app = App::getInstance();
		$app->setEventManager($eventManager);
		return $app;
	}
}
