<?php

namespace Txsoura\Core\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait CRUDMethodsController
{
    public function index(Request $request)
    {
        $models = $this->service
            ->setRequest($request)
            ->index();

        return $this->resource::collection($models);
    }

    public function store(Request $request)
    {
        $model = $this->service
            ->setRequest($request)
            ->store();

        return new $this->resource($model);
    }

    public function show(Request $request)
    {
        $id = Arr::last(func_get_args());

        $model = $this->service
            ->setRequest($request)
            ->show($id);

        return new $this->resource($model, 200);
    }

    public function update(Request $request)
    {
        $id = Arr::last(func_get_args());

        $model = $this->service
            ->setRequest($request)
            ->update($id);

        return new $this->resource($model, 200);
    }

    public function destroy(Request $request)
    {
        $id = Arr::last(func_get_args());

        $this->service->destroy($id);

        return response()->json([
            'message' => trans('core::message.deleted')
        ]);
    }
}
