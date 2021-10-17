<?php

namespace Txsoura\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait SoftDeleteMethodsController
{
    public function forceDestroy()
    {
        $id = Arr::last(func_get_args());

        if (!$this->service->forceDestroy($id)) {
            return response()->json([
                'message' => trans('core::message.delete_failed')
            ], 400);
        }

        return response()->json([
            'message' => trans('core::message.deleted')
        ]);
    }

    public function restore()
    {
        $id = Arr::last(func_get_args());

        if (!$this->service->restore($id)) {
            return response()->json([
                'message' => trans('core::message.restore_failed')
            ], 400);
        }

        return response()->json([
            'message' => trans('core::message.restored')
        ]);
    }
}
