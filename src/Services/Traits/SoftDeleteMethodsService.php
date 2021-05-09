<?php

namespace Txsoura\Core\Services\Traits;

trait SoftDeleteMethodsService
{
    public function forceDestroy($id)
    {
        $model = $this->model()::withTrashed()
            ->whereId($id)
            ->firstOrFail();
        $model->forceDelete();
    }

    public function restore($id)
    {
        $model = $this->model()::withTrased()
            ->whereId($id)
            ->firstOrFail();
        $model->restore();
    }
}
