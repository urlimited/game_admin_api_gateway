<?php

namespace App\Containers\ConfigurationSection\Adjustment\Enums;

enum AdjustmentStatus: string
{
    case Active = 'active';
    case OnCheck = 'on_check';
    case Inactive = 'inactive';
}
