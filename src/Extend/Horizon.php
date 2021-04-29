<?php

namespace Blomstra\Horizon\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

class Horizon implements ExtenderInterface
{
    private $config;
    private $environment;

    public function extend(Container $container, Extension $extension = null)
    {
        $repository = $container->make(Repository::class);

        if ($this->config) {
            $repository->set('horizon', $this->config);
        }

        if ($this->environment) {
            $repository->set("horizon.environments.{$container->make('env')}", $this->environment);
        }
    }

    /**
     * Use a configuration file or array to configure Horizon.
     *
     * @param string|array $config
     * @return Horizon
     */
    public function config($config)
    {
        if (is_string($config)) {
            $this->config = include $config;
        } else {
            $this->config = (array) $config;
        }

        return $this;
    }

    /**
     * @param array|string $config
     * @return $this
     */
    public function environment($config)
    {
        if (is_string($config)) {
            $this->environment = include $config;
        } else {
            $this->environment = (array) $config;
        }

        return $this;
    }
}
