<?php

declare(strict_types=1);

namespace Api\Service;

use Laminas\Http\PhpEnvironment\Request;
use Psr\Container\ContainerInterface;

if (! defined('SMF')) {
	die('No direct access...');
}

final class RequestFactory
{
	public function __invoke(ContainerInterface $container): Request
	{
		return new Request();
	}
}
