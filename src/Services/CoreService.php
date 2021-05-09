<?php

namespace Txsoura\Core\Services;

use Txsoura\Core\Helpers;

abstract class CoreService
{
    use Helpers;

    /**
     * Model class for crud.
     *
     * @return string
     */
    abstract protected function model(): string;
}
