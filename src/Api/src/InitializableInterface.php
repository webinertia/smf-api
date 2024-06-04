<?php

declare(strict_types=1);

namespace Api;

if (! defined('SMF')) {
	die('No direct access...');
}

interface InitializableInterface
{
    public function init(): void;
}
