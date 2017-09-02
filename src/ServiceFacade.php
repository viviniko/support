<?php

namespace Common\Support;

abstract class ServiceFacade
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new catalog instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}