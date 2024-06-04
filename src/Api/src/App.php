<?php

declare(strict_types=1);

namespace Api;

use Api\Event\Event;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\EventManager\EventManagerInterface;
use SMF\IntegrationHook;
use SMF\Forum;

if (! defined('SMF')) {
	die('No direct access...');
}

final class App implements RequestAwareInterface
{
	use RequestAwareTrait;

	protected static $eventManager;
	protected static $instance;

	public static function getInstance(): self
	{
		if (! isset(static::$instance)) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	public function run()
	{
		IntegrationHook::add(
			name: 'integrate_actions',
			function: static::class .'::addAction',
			permanent: false,
			object: true
		);
		//$this->getEventManager()->trigger(Event::Actions->value);
	}

	public function setEventManager(EventManagerInterface $events)
	{
		static::$eventManager = $events;
	}

	public function getEventManager(): EventManagerInterface
	{
		return static::$eventManager;
	}

	public static function addAction(&$actions)
	{
		$actions += ['api' => ['', static::class .'::apiAction']];
	}

	public static function apiAction()
	{
		static::$eventManager->trigger(Event::Api->value);
	}
}
