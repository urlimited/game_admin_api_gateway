<?php

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisWhereHasThatCriteria extends Criteria
{
    private string $field;

    private string $value;

    private string $relation;

    public function __construct(string $relation, string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
        $this->relation = $relation;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereHas($this->relation, fn($q) => $q->where($this->field, $this->value));
    }
}
