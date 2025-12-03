<?php

namespace Txsoura\Core;

use Illuminate\Http\Request;

trait Helpers
{
    /**
     * @var Request
     */
    protected $request = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $booleanParams = [];

    /**
     * @param Request $request
     * @return $this
     */
    function setRequest(Request $request)
    {
        $this->request = array_merge($request->all());
        return $this;
    }

    /**
     * @return $this
     */
    function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return $this
     */
    function setBooleanParams(array $booleanParams)
    {
        $this->booleanParams = $booleanParams;
        return $this;
    }
}
