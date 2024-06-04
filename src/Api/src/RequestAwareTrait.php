<?php

declare(strict_types=1);

namespace Api;

use Laminas\Http\PhpEnvironment\Request;

if (! defined('SMF')) {
	die('No direct access...');
}

trait RequestAwareTrait
{
	protected ?Request $request = null;

	public function getRequest(): ?Request
	{
		return $this->request;
	}

	public function setRequest(Request $request): void
	{
		$this->request = $request;
	}
}
