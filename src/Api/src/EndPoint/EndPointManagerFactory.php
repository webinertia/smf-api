<?php

declare(strict_types=1);

namespace Api\EndPoint;

use Api\ConfigProvider;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

final class EndPointManagerFactory
{
	public function __invoke(ContainerInterface $container): EndPointManager
	{
		if (! $container->has('config')) {
			throw new ServiceNotFoundException('EndpointManager requires a config service');
		}
		$config = $container->get('config');
		if (! isset($config['endpoint_manager'])) {
			throw new ServiceNotCreatedException('Missing configuration for EndPointManager.');
		}
		return new EndPointManager($container, $config['endpoint_manager']);
	}
}
