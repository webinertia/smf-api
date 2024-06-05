<?php

declare(strict_types=1);

namespace Api\Service;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;

if (! defined('SMF')) {
	die('No direct access...');
}

final class EventManagerAwareInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $instance)
	{
		if (! $instance instanceof EventManagerAwareInterface) {
			return;
		}
		/** @var EventManagerInterface */
		$em = $instance->getEventManager();
		if ($em instanceof EventManagerInterface) {
			return;
		}
		$instance->setEventManager($container->get(EventManagerInterface::class));
	}
}
