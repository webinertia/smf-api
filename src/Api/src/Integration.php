<?php declare(strict_types=1);

namespace Api;

use Api\Event\CurrentActionEvent;
use Api\Event\Event as EventType;
use Api\Event\SMFEvent;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;
use SMF\IntegrationHook;
use SMF\Forum;

use function add_integration_function;

use const SMF;

if (! defined('SMF')) {
	die('No direct access...');
}

/**
 * Proxy SMF hooks to EventManager events
 */
final class Integration
{
	protected static $eventManager;
	protected static $instance;
	protected static $request;
	protected static $api;

	public static function getInstance(
		EventManagerInterface $eventManager,
		Request $request,
	): self {
		static::$eventManager = $eventManager;
		static::$eventManager->addIdentifiers([static::class]);
		static::$request = $request;

		if (! isset(static::$instance)) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	public static function init(): void
	{
		if ('BACKGROUND' !== SMF) {
			IntegrationHook::add(
				name: SMFEvent::Actions->value,
				function: __CLASS__ . EventType::Actions->value,
				permanent: false,
				file: __FILE__,
				object: true,
			);
			IntegrationHook::add(
				name: SMFEvent::DefaultAction->value,
				function: __CLASS__ . EventType::DefaultAction->value,
				permanent: false,
				file: __FILE__,
				object: true
			);
			IntegrationHook::add(
				name: SMFEvent::CurrentAction->value,
				function: __CLASS__ . EventType::CurrentAction->value,
				permanent: false,
				file: __FILE__,
				object: true
			);
			IntegrationHook::add(
				name: SMFEvent::LoadTheme->value,
				function: __CLASS__ . EventType::LoadTheme->value,
				permanent: false,
				object: true
			);
		}

		// $this->applyHook('load_theme');
		// $this->applyHook('actions');
		// $this->applyHook('default_action');
		// $this->applyHook('current_action');
		// $this->applyHook('load_illegal_guest_permissions');
		// $this->applyHook('load_permissions');
		// $this->applyHook('alert_types');
		// $this->applyHook('fetch_alerts');
		// $this->applyHook('profile_areas');
	}

	// non proxied method
	// public static function addAction() {
	// 	Forum::$actions += ['api' =>  [, []]];
	// }

	public static function defaultAction()
	{
		/**
		 * from this point the event workflow can get as complex as required
		 *
		 * Bare in mind this is the absolute bare minimum implementation
		 * This could use a factoried custom Event object and we could call triggerEvent and pass the event.
		 * We could also pass a target here. I mean its hard to explain how many different ways this could
		 * work.
		 */
		static::$eventManager->trigger(
			EventType::DefaultAction->value,
			null,
			[
				'key_one' => 'value_one'
			],
		);
	}

	public static function currentAction(string &$action)
	{
		// Custom Event example
		$currentAction = new CurrentActionEvent(EventType::CurrentAction->value);
		$currentAction->setParams(['action' => $action]);
		static::$eventManager->triggerEvent($currentAction);
	}

	/**
	 * trigger order 1
	 * @return void
	 */
	public static function loadTheme()
	{
		$event = new Event(EventType::LoadTheme->value);
		$event->setParams(['action', static::$request->getQuery()->get('action', 'unknown_action')]);
		static::$eventManager->triggerEvent($event);
	}
}
