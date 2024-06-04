<?php

declare(strict_types=1);

namespace Api\Service;

use Api\RequestAwareInterface;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\ServiceManager\Initializer\InitializerInterface;
use Psr\Container\ContainerInterface;

if (! defined('SMF')) {
	die('No direct access...');
}

final class RequestAwareInitializer implements InitializerInterface
{
    public function __invoke(ContainerInterface $container, $instance)
	{
		if (! $instance instanceof RequestAwareInterface) {
			return;
		}
		/** @var Request */
		$request = $instance->getRequest();
		if ($request instanceof Request) {
			return;
		}
		$instance->setRequest($container->get(Request::class));
	}
}
