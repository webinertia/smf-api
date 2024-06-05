<?php

declare(strict_types=1);

namespace Api\Event\Listener;

use Api\Event\Event;
use Api\RequestAwareInterface;
use Api\RequestAwareTrait;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\Header\ContentType;
use Laminas\Http\PhpEnvironment\Response;
use RuntimeException;
use SMF\Config;
use SMF\Utils;

use function ob_end_clean;
use function ob_start;

final class ApiListener extends AbstractListenerAggregate implements RequestAwareInterface
{
	use RequestAwareTrait;

	private const TARGET_PARAM = 'api';

	public function attach(EventManagerInterface $events, $priority = 1)
	{
		$this->listeners[] = $events->attach(
			Event::Api->value,
			[$this, 'onApiStartUp'],
			10000
		);

		$this->listeners[] = $events->attach(
			Event::Api->value,
			[$this, 'onApiAction'],
			$priority
		);

		$this->listeners[] = $events->attach(
			Event::Api->value,
			[$this, 'onApiShutDown'],
			-10000
		);
	}

	public function OnApiStartUp(EventInterface $event)
	{
		ob_end_clean();
		if (!empty(Config::$modSettings['enableCompressedOutput']))
			@ob_start('ob_gzhandler');
		else
			ob_start();
	}

	/**
	 * This needs to be refactored to use the passed event target and argv, we may get a custom event
	 * @param EventInterface $event
	 * @return void
	 */
	public function onApiAction(EventInterface $event)
	{

		$eventContext = $event->getParams();
		$uri = $this->request->getUri();
		$params = $uri->getQueryAsArray();

		/** @var Laminas\Http\PhpEnvironment\Response */
		$response = new Response();
		$response->setHeadersSentHandler(function ($response): void {
			throw new RuntimeException('Cannot send headers, headers already sent');
		});
		$response->setStatusCode(Response::STATUS_CODE_200);
		$contentType = new ContentType('application/json');
		$headers = $response->getHeaders();
		$headers->addHeader($contentType);
		$headers->addHeaders([
			'X-Content-Type-Options' => 'nosniff',
			'HeaderField1' => 'header-field-value1',
			'HeaderField2' => 'header-field-value2',
		]);
		$data = [
			'body_param_one' => 'body_param_one_value',
			'body_param_two' => 'body_param_two_value',
		];
		$response->setContent(\json_encode($data));
		$response->send();
	}

	public function onApiShutDown()
	{
		Utils::obExit(false);
	}
}
