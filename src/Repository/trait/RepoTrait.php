<?php

namespace App\Repository\trait;

use App\Entity\BaseModel;

trait RepoTrait
{
    public function save(BaseModel $model): void
    {
        $this->getEntityManager()->persist($model);
        $this->getEntityManager()->flush();
    }
}