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
     * ayarlarý tutar
     *
     *
     * @var array -> config
     */
    private $config;


    /**
     * Ayarlarý kullanýr
     *
     * @param DriverInterface $driver
     * @param array $config
     */
    public function __construct(DriverInterface $driver, array $config = [])
    {
        $this->setDriver($driver);
        $this->setConfig($config);

        $this->useDefaults();
    }

    /**
     *
     * Ön tanýmlý ayarlarý ayarlar
     */
    private function useDefaults()
    {
        $this->setDriverList([
            'local' => LocalDriver::class,
        ]);
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
     * @return Cache
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @return array
     */
    public function getDriverList()
    {
        return $this->driverList;
    }

    /**
     * @param array $driverList
     * @return Cache
     */
    public function setDriverList($driverList)
    {
        $this->driverList = $driverList;
        return $this;
    }

    /**
     * Ayarlarý döndürür
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Ayarlarý ayarlar
     *
     * @param array $config
     * @return Cache
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }


}
