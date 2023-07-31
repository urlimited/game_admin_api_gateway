<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Enums;

enum ConditionOperator: string
{
    case More = '>';
    case Less = '<';
    case In = 'in';
    case Equal = '=';
}
