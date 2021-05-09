<?php

namespace Txsoura\Core\Services\Traits;

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

        return $this->model()::create($this->request->validated());
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
        $model->update($this->request->validated());
        return $model;
    }

    public function destroy($id)
    {
        $model = $this->model()::findOrFail($id);
        $model->delete();
    }
}
