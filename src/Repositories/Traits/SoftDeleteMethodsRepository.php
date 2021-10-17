<?php

namespace Txsoura\Core\Repositories\Traits;

trait SoftDeleteMethodsRepository
{
    /**
     * @param int $id
     * @return Model|null
     */
    public function findWithTrashed($id)
    {
        return $this->model()::withTrashed()
            ->where('id', $id)
            ->when(key_exists('include', $this->request), function ($query) {
                if ($this->checkIncludeColumns()) {
                    return $query->with(explode(',', $this->request['include']));
                }

                return $query;
            })
            ->first();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function findOrFailWithTrashed($id)
    {
        return $this->model()::withTrashed()
            ->where('id', $id)
            ->when(key_exists('include', $this->request), function ($query) {
                if ($this->checkIncludeColumns()) {
                    return $query->with(explode(',', $this->request['include']));
                }

                return $query;
            })
            ->firstOrFail();
    }
}
