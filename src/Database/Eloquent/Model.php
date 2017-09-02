<?php

namespace Viviniko\Support\Database\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;

class Model extends Eloquent
{
    /**
     * @var string
     */
    protected $tableConfigKey;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($this->tableConfigKey) {
            $this->table = Config::get($this->tableConfigKey);
        }
    }
}