<?php

namespace Txsoura\Core\Services\Traits;

trait SoftDeleteMethodsRepository
{
    /**
     * @param int $id
     * @return Model|null
     */
    public function findWithTrased($id)
    {
        return $this->model()::withTrashed()
            ->where('id', $id)
            ->when(key_exists('include', $this->request), function ($query) {
                return $query->with(explode(',', $this->request['include']));
            })
            ->first();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function findOrFailWithTrased($id)
    {
        return $this->model()::withTrashed()
            ->where('id', $id)
            ->when(key_exists('include', $this->request), function ($query) {
                return $query->with(explode(',', $this->request['include']));
            })
            ->firstOrFail();
    }
}
