<?php

declare(strict_types=1);

namespace Api;

use Api\EndPoint;
use Api\EndPoint\EndPoint as EndPointEndPoint;
use Api\Event\Listener;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\ServiceManager\Factory\InvokableFactory;

if (! defined('SMF')) {
	die('No direct access...');
}

final class ConfigProvider
{
	public function __invoke(): array
	{
		return [
			'dependencies'     => $this->getDependencies(),
			'endpoint_manager' => $this->getEndPointConfig(),
		];
	}

	public function getDependencies(): array
	{
		return [
			'aliases'   => [
				// expose support for various laminas packages that expect this alias for EventManager
				'EventManager' => EventManager::class,
				EventManagerInterface::class => EventManager::class,
			],
			'factories' => [
				App::class                  => Service\AppFactory::class,
				EventManager::class         => Service\EventManagerFactory::class,
				Listener\ApiListener::class => InvokableFactory::class,
				Request::class              => Service\RequestFactory::class,
				EndPoint\EndPointManager::class => EndPoint\EndPointManagerFactory::class,
			],
			'initializers' => [
				Service\RequestAwareInitializer::class,
			],
		];
	}

	public function getEndPointConfig(): array
	{
		return [
			'aliases' => [
				EndPoint\EndPoint::Board->value => EndPoint\Board::class,
			],
			'factories' => [
				EndPoint\Board::class => InvokableFactory::class,
			],
			'initializers' => [
				Service\RequestAwareInitializer::class,
			],
		];
	}
}
