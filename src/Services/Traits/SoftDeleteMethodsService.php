<?php

namespace Txsoura\Core\Services\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait SoftDeleteMethodsService
{
    public function forceDestroy($id)
    {
        $model = $this->model()::withTrashed()
            ->whereId($id)
            ->firstOrFail();

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
        $model = $this->model()::withTrased()
            ->whereId($id)
            ->firstOrFail();

        try {
            $model->restore();

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}
