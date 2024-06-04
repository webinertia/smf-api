<?php

declare(strict_types=1);

namespace Api;

use Laminas\Http\PhpEnvironment\Request;

if (! defined('SMF')) {
	die('No direct access...');
}

interface RequestAwareInterface
{
	public function getRequest(): ?Request;
	public function setRequest(Request $request): void;
}
