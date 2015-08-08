<?php

namespace Anonym\Components\Cache;

/**
 * Class Cache
 * @package Anonym\Components\Cache
 */
class Cache
{

    /**
     * Sürücü objesini tutar
     *
     * @var DriverInterface
     */
    private $driver;


    /**
     * Sürücü listesini tutar
     *
     * @var array
     */
    private $driverList;


    /**
     * Ayarları kullanır
     *
     * @param DriverInterface $driver
     * @param array $config
     */
    public function __construct(DriverInterface $driver, array $config = [])
    {
        $this->setDriver($driver ,$config);
    }


    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface $driver
     * @param array $configs
     * @throws DriverNotInstalledException
     * @return Cache
     */
    public function setDriver(DriverInterface $driver, array $configs = [])
    {


        $this->driver = $driver;
        $this->driver->boot($configs);

        if(true !== $driver->check())
        {
            throw new DriverNotInstalledException(sprintf('%s sürücünüz kullanıma hazır değil.', get_class($driver)));
        }


        return $this;
    }
    /**
     * Dinamik olarak sürücüden method çağrılır
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        return call_user_func_array([$this->getDriver(), $name], $args);
    }

}
