<?php

declare(strict_types=1);

namespace Api\EndPoint;

use Laminas\Http\PhpEnvironment\Request;

interface EndPointInterface
{
	public final const SUPPORTED_METHODS = [
		Request::METHOD_GET,
		Request::METHOD_POST
	];

	public function respond(): void;
}
