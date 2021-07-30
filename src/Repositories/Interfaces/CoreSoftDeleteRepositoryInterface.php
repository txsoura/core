<?php

namespace Txsoura\Core\Repositories\Interfaces;

interface CoreSoftDeleteRepositoryInterface
{
    public function findWithTrased($id);

    public function findOrFailWithTrased($id);
}
