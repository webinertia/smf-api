<?php

declare(strict_types=1);

namespace Api;

use Api\EndPoint\EndPoint;
use Api\EndPoint\EndPointManager;
use Api\Event\Event;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;
use SMF\IntegrationHook;
use SMF\Forum;

if (! defined('SMF')) {
	die('No direct access...');
}

final class App
{
	private const TARGET_PARAM = 'endpoint';
	private const SMF_HOOK = 'integrate_actions';

	protected static EndPointManager $endPointManager;
	protected static EventManager $eventManager;
	protected static Request $request;
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
			name: self::SMF_HOOK,
			function: static::class .'::addAction',
			permanent: false,
			object: true
		);
	}

	public function setRequest(Request $request): void
	{
		static::$request = $request;
	}

	public function getRequest(): Request
	{
		return static::$request;
	}

	public static function apiAction()
	{
		$endpoint = EndPoint::tryFrom(static::$request->getQuery(self::TARGET_PARAM));

		// currently only matches ?action=api&endpoint=board
		$target = match($endpoint) {
			EndPoint::Board => (static::$endPointManager->get(EndPoint::Board->value)),
			default => throw new \RuntimeException('Unknown Endpoint')
		};
		// This is kinda janky, but its what ya get when SMF is built the way it is :(
		$target->setEventManager(static::$eventManager);
		$target->respond();
	}

	public function setEventManager(EventManagerInterface $events)
	{
		static::$eventManager = $events;
	}

	public function getEventManager(): EventManagerInterface
	{
		return static::$eventManager;
	}

	public function setEndPointManager(EndPointManager $manager): void
	{
		static::$endPointManager = $manager;
	}

	public function getEndPointManager(): EndPointManager
	{
		return static::$endPointManager;
	}

	public static function addAction(&$actions)
	{
		$actions += ['api' => ['', static::class .'::apiAction']];
	}
}
