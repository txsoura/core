<?php

namespace Txsoura\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait SoftDeleteMethodsController
{
    public function forceDestroy(Request $request)
    {
        $id = Arr::last(func_get_args());

        $this->service->forceDestroy($id);

        return response()->json([
            'message' => trans('core::message.deleted')
        ]);
    }

    public function restore(Request $request)
    {
        $id = Arr::last(func_get_args());

        $this->service->restore($id);

        return response()->json([
            'message' => trans('core::message.restored')
        ]);
    }
}
