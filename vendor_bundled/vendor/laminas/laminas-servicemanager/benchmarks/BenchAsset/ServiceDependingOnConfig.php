<?php

namespace LaminasBench\ServiceManager\BenchAsset;

class ServiceDependingOnConfig
{
    /** @var array */
    public $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
