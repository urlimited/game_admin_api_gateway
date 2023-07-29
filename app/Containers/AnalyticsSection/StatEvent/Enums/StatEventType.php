<?php

namespace App\Containers\AnalyticsSection\StatEvent\Enums;

enum StatEventType: string
{
    // Something that can represent any value
    case ValueBased = 'value_based';

    // Something that can represent numeric value
    case Quantitative = 'quantitative';

    // Something that can represent only fact of some event
    case FactBased = 'fact_based';
}
