<?php

namespace Viviniko\Support;

use Illuminate\Http\Request;

abstract class AbstractRequestRepositoryService extends AbstractRepositoryService
{
    protected $pageSize = 25;

    protected $requestParamName = 'search';

    protected $searchRules = [];

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->searchOptions = [
            'page_size' => $this->pageSize,
            'request_param_name' => $this->requestParamName,
            'rules' => $this->searchRules,
        ];
    }

    /**
     * Paginate repository.
     * @param null $pageSize
     * @param array $wheres
     * @param array $orders
     * @return mixed
     */
    public function paginate($pageSize = null, $wheres = [], $orders = [])
    {
        $options = $this->searchOptions;
        if ($pageSize > 0) {
            $options['page_size'] = $pageSize;
        }

        return parent::paginateByRequest($this->getRequest(), $options, $wheres, $orders);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
}