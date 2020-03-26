<?php


namespace Royalcms\Component\Live;


use Illuminate\Cache\CacheManager;
use Royalcms\Component\Live\Paas\Room;

class LiveManager
{

    /**
     * The array of resolved cache stores.
     *
     * @var array
     */
    protected $stores = [];

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Create a new Cache manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function room()
    {
        return $this->get('room');
    }

    /**
     * Attempt to get the store from the local cache.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function get($name)
    {
        return $this->stores[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->getConfig();

        if (isset($this->customCreators[$name])) {
            return $this->callCustomCreator($config);
        } else {
            $driverMethod = 'create'.ucfirst($name).'Driver';

            if (method_exists($this, $driverMethod)) {
                return $this->{$driverMethod}($config);
            } else {
                throw new InvalidArgumentException("Driver [{$name}] is not supported.");
            }
        }
    }

    /**
     * Get the cache connection configuration.
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->app['config']["live"];
    }

    /**
     * Create an instance of the APC cache driver.
     *
     * @param  array  $config
     * @return
     */
    protected function createRoomDriver(array $config)
    {
        return new Room($config);
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $config
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string  $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }
}