<?php

namespace Txsoura\Core\Repositories\Interfaces;

interface CoreRepositoryInterface
{
    public function all();

    public function find($id);

    public function findOrFail($id);
}
