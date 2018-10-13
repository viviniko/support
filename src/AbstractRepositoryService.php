<?php

namespace Viviniko\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;
use Viviniko\Repository\SearchPageRequest;

abstract class AbstractRepositoryService
{
    use Macroable {
        __call as macroCall;
    }

    protected $searchOptions = [
        'page_size' => 25,
        'request_param_name' => 'search',
        'rules' => [],
    ];

    /**
     * Paginate repository.
     *
     * @param \Illuminate\Http\Request $request
     * @param null $options
     * @param array $wheres
     * @param array $orders
     * @return mixed
     */
    public function paginateByRequest(Request $request, $options = null, $wheres = [], $orders = [])
    {
        $options = $options instanceof Arrayable ? $options->toArray() : ($options ?? []);
        $options = array_merge($this->searchOptions, $options);

        return $this->getRepository()->search(
            SearchPageRequest::create($options['page_size'], $wheres, $orders)
                ->rules($options['rules'])
                ->request($request, $options['request_param_name'])
        );
    }

    /**
     * Dynamically call.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->getRepository()->{$method}(...$parameters);
    }

    /**
     * @return \Viviniko\Repository\CrudRepository
     */
    abstract public function getRepository();
}