<?php

declare(strict_types=1);

namespace Api\EndPoint;

use Api\Event\Event;
use Api\RequestAwareInterface;
use Api\RequestAwareTrait;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\Http\PhpEnvironment\Request;

abstract class AbstractEndPoint implements EndPointInterface, EventManagerAwareInterface, RequestAwareInterface
{
	use EventManagerAwareTrait;
	use RequestAwareTrait;

}
