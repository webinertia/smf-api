<?php

declare(strict_types=1);

namespace Api;

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
			'dependencies' => $this->getDependencies(),
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
				//AddonHandler::class           => Service\AddonHandlerFactory::class,
				App::class                    => Service\AppFactory::class,
				// Actions\Block::class          => InvokableFactory::class,
				// Actions\BoardIndex::class     => InvokableFactory::class,
				// Actions\BoardIndexNext::class => InvokableFactory::class,
				// Actions\Category::class       => InvokableFactory::class,
				// Actions\FrontPage::class      => InvokableFactory::class,
				// Actions\Page::class           => InvokableFactory::class,
				// Actions\Tag::class            => InvokableFactory::class,
				EventManager::class               => Service\EventManagerFactory::class,
				Event\Listener\ApiListener::class => InvokableFactory::class,
				// Events\Listeners\SmfHookListener::class => Events\Listeners\SmfHookListenerFactory::class,
				//Integration::class                      => Service\IntegrationFactory::class,
				Request::class                          => Service\RequestFactory::class,
				//Repositories\PluginRepository::class     => InvokableFactory::class,
				//Utils\Request::class                     => InvokableFactory::class,
			],
			'initializers' => [
				Service\RequestAwareInitializer::class,
			],
		];
	}
}
