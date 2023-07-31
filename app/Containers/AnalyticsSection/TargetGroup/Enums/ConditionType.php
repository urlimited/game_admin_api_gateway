<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Enums;

enum ConditionType: string
{
    case PlayerData = 'player_data';
    case StatEvent = 'stat_event';
}
