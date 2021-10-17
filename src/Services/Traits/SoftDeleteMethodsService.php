<?php

namespace Txsoura\Core\Services\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait SoftDeleteMethodsService
{
    public function forceDestroy($id)
    {
        $model = $this->repository->findOrFailWithTrashed($id);

        try {
            $model->forceDelete();

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function restore($id)
    {
        $model = $this->repository->findOrFailWithTrashed($id);

        try {
            $model->restore();

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}
