<?php

namespace App\Ship\Libs\OptimisedUuid;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Grammars\MySqlGrammar as IlluminateMySqlGrammar;

class MySqlGrammar extends IlluminateMySqlGrammar
{
    protected function typeBinaryUuid(Fluent $column): string
    {
        return 'binary(16)';
    }
}
