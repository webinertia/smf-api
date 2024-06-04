<?php

declare(strict_types=1);

namespace Api\Event\Listener;

use Api\Event\CurrentActionEvent;
use Api\Event\Event;
use Api\RequestAwareInterface;
use ApiRequestAwareTrait;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\PhpEnvironment\Request;

final class SmfHookListener extends AbstractListenerAggregate implements RequestAwareInterface
{
	use RequestAwareTrait;

	public function attach(EventManagerInterface $events, $priority = 1)
	{
		$this->listeners[] = $events->attach(
			Event::SmfHook->value,
			[$this, 'onSmfHook'],
			$priority
		);

		$this->listeners[] = $events->attach(
			Event::DefaultAction->value,
			[$this, 'onDefaultAction'],
			$priority
		);

		$this->listeners[] = $events->attach(
			Event::CurrentAction->value,
			[$this, 'onCurrentAction'],
			$priority
		);

		$this->listeners[] = $events->attach(
			Event::LoadTheme->value,
			[$this, 'onResetTemplateLayers'],
			-100
		);
	}

	public function onSmfHook(EventInterface $event)
	{
	}

	public function onDefaultAction(EventInterface $event)
	{

	}

	public function onCurrentAction(CurrentActionEvent $event)
	{
		$filterTest = 'ThisIsAString';
		$filtered = $this->snakeNameFilter->filter($filterTest);
		$target  = $event->getTarget();
		$action  = $event->getParam('action');
	}

	public function onLoadTheme(EventInterface $event)
	{
	}

	public function onResetTemplateLayers(EventInterface $event)
	{
		$action = $event->getParam('action');
		if ($action === Event::Api->value && ! empty(Utils::$context['template_layers'])) {
			Utils::$context['template_layers'] = [];
		}
	}
}
