<?php

declare(strict_types=1);

namespace Api\Event\Listener;

use Laminas\Filter\FilterPluginManager;
use Laminas\Http\PhpEnvironment\Request;
use Psr\Container\ContainerInterface;

final class SmfHookListenerFactory
{
	public function __invoke(ContainerInterface $container): SmfHookListener
	{
		$filterManager = $container->get(FilterPluginManager::class);
		$snakeNameFilter = $filterManager->get(SnakeNameFilter::class);
		return new SmfHookListener();
	}
}
