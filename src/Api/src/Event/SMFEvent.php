<?php

declare(strict_types=1);

namespace Api\Event;

enum SMFEvent: string
{
	case Actions       = 'integrate_actions';
	case CurrentAction = 'integrate_current_action';
	case DefaultAction = 'integrate_default_action';
	case LoadTheme     = 'integrate_load_theme';
}
