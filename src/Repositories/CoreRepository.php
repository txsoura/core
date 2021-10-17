<?php


namespace Txsoura\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Txsoura\Core\Helpers;
use Txsoura\Core\Repositories\Interfaces\CoreRepositoryInterface;
use Txsoura\Core\Repositories\Traits\QueryFilterRepository;

abstract class CoreRepository implements CoreRepositoryInterface
{
    use Helpers, QueryFilterRepository;

    /**
     * Allow model relations to use in include
     * @var array
     */
    protected $possibleRelationships = [];

    /**
     * Model class instance.
     *
     * @return string
     */
    abstract protected function model(): string;

    /**
     * Allowed model columns to use in conditional query
     * @var array
     */
    protected $allow_where = array();

    /**
     * Allowed model columns to use in sort
     * @var array
     */
    protected $allow_order = array();

    /**
     * Allowed model columns to use in query search
     * @var array
     */
    protected $allow_like = array();

    /**
     * Allowed model columns to use in filter by date
     * @var array
     */
    protected $allow_between_dates = array();

    /**
     * Allowed model columns to use in filter by value
     * @var array
     */
    protected $allow_between_values = array();

    /**
     * Get all model data, with filters if required
     *
     * @return Collection|Paginator
     */
    public function all()
    {
        $this->setParams($this->checkWhereColumns());

        $models = $this->model()::when(key_exists('onlyTrashed', $this->request), function ($query) {
            if ($this->request['onlyTrashed']){
                $query->onlyTrashed();
            }

            return $query;
        })
            ->when(key_exists('withTrashed', $this->request), function ($query) {
                if ($this->request['withTrashed']){
                    return $query->withTrashed();
                }

                return $query;
            })
            ->when(key_exists('date_column', $this->request), function ($query) {
                if ($this->checkDateColumns()) {
                    if (key_exists('date_start', $this->request))
                        $query->where($this->request['date_column'], '>=', $this->request['date_start']);
                    if (key_exists('date_end', $this->request))
                        $query->where($this->request['date_column'], '<=', $this->request['date_end']);
                }

                return $query;
            })
            ->when(key_exists('value_column', $this->request), function ($query) {
                if ($this->checkValueColumns()) {
                    if (key_exists('value_min', $this->request))
                        $query->where($this->request['value_column'], '>=', $this->request['value_min']);
                    if (key_exists('value_max', $this->request))
                        $query->where($this->request['value_column'], '<=', $this->request['value_max']);
                }

                return $query;
            })
            ->when(key_exists('q', $this->request), function ($query) {
                if ($this->checkQueryColumns()) {
                    foreach ($this->allow_like as $column) {
                        $query->orWhere($column, 'like', '%' . $this->request['q'] . '%');
                    }
                }

                return $query;
            })
            ->when($this->params, function ($query) {
                foreach (array_keys($this->params) as $column) {
                    $query->where($column, $this->params[$column]);
                }

                return $query;
            })
            ->when(key_exists('sort', $this->request), function ($query) {
                $columns = explode(',', $this->request['sort']);

                if ($this->checkSortColumns($columns)) {
                    foreach ($columns as $column) {
                        if (Str::contains($column, '-')) {
                            $query->orderBy(substr($column, 1), 'desc');
                        } else {
                            $query->orderBy($column, 'asc');
                        }
                    }
                }

                return $query;
            })
            ->when(key_exists('take', $this->request), function ($query) {
                return $query->limit($this->request['take']);
            })
            ->when(key_exists('include', $this->request), function ($query) {
                if ($this->checkIncludeColumns()) {
                    $query->with(explode(',', $this->request['include']));
                }

                return $query;
            });

        if (key_exists('paginate', $this->request)) {
            return $models->paginate($this->request['paginate']);
        } else {
            return $models->get();
        }
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->model()::where('id', $id)
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
    public function findOrFail($id)
    {
        return $this->model()::where('id', $id)
            ->when(key_exists('include', $this->request), function ($query) {
                if ($this->checkIncludeColumns()) {
                    return $query->with(explode(',', $this->request['include']));
                }

                return $query;
            })
            ->firstOrFail();
    }

}
