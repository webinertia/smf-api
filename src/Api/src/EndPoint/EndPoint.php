<?php

declare(strict_types=1);

namespace Api\EndPoint;

enum EndPoint: string
{
	// should match the querystring param for endpoint=$target
	case Board = 'board';
	case Topic = 'topic';
	case Reply = 'reply';
	case User  = 'user';
}
