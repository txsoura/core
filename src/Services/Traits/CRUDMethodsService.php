<?php

namespace Txsoura\Core\Services\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Txsoura\Core\Http\Requests\QueryParamsRequest;

trait CRUDMethodsService
{
    protected $queryParamsRequest = QueryParamsRequest::class;

    public function index()
    {
        $this->request = resolve($this->queryParamsRequest);

        return $this->repository->setRequest($this->request)->all();
    }

    public function store()
    {
        $this->request = resolve($this->storeRequest);

        try {
            return $this->model()::create($this->request->validated());
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function show($id)
    {
        $this->request = resolve($this->queryParamsRequest);

        return $this->repository->setRequest($this->request)->findOrFail($id);
    }

    public function update($id)
    {
        $this->request = resolve($this->updateRequest);

        $model = $this->repository->findOrFail($id);

        try {
            $model->update($this->request->validated());

            return $model;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function destroy($id)
    {
        $model = $this->repository->findOrFail($id);

        try {
            $model->delete();

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}
