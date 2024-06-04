<?php

declare(strict_types=1);

namespace Api\Event;

enum Event: string
{
	case Api           = '::ApiAction';
	case Actions       = '::addAction';
	case DefaultAction = '::defaultAction';
	case CurrentAction = '::currentAction';
	case LoadTheme     = '::loadTheme';
}
