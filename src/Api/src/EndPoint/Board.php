<?php

declare(strict_types=1);

namespace Api\EndPoint;

use Api\Event\Event;

final class Board extends AbstractEndPoint
{
	/**
	 * These classes will be factoried through the EndPointManager so they can bring in
	 * whatever dependencies they will need to do their work
	 * @return void
	 */
	public function __construct()
	{
		/**
		 * inject params
		 * handle logic
		 */
	}

	public function respond(): void
	{
		$method = $this->request->getMethod();
		/**
		 * trigger the Api event so as to return the composed response
		 */
		$this->getEventManager()->trigger(Event::Api->value, $this);
	}
}
