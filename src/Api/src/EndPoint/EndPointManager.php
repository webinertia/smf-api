<?php

declare(strict_types=1);

namespace Api\EndPoint;

use Laminas\ServiceManager\AbstractPluginManager;

final class EndPointManager extends AbstractPluginManager
{
	protected $instance = EndPointInterface::class;
}
