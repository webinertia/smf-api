<?php

declare(strict_types=1);

namespace Api\Service;

use Api\Integration;
use Api\Event\Listener\ApiListener;
use Api\Event\Listener\SmfHookListener;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;
use Psr\Container\ContainerInterface;

final class IntegrationFactory
{
	public function __invoke(ContainerInterface $container): Integration
	{
		$eventManager = $container->get(EventManagerInterface::class);
		$eventManager->setIdentifiers([Integration::class]);
		/** @var SmfHookListener */
		$listener = $container->get(SmfHookListener::class);
		$listener->attach($eventManager, 10000); // attach listener and insure this listener runs first
		/** @var ApiListener */
		$listener = $container->get(ApiListener::class);
		$listener->attach($eventManager, 9999); // insure this listener runs second
		return Integration::getInstance(
			$container->get(EventManagerInterface::class),
			$container->get(Request::class)
		);
	}
}
