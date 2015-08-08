<?php

namespace Anonym\Components\Cache;

/**
 * Class Cache
 * @package Anonym\Components\Cache
 */
class Cache
{

    /**
     * Sürüclerin listesini tutar
     *
     *
     * @var  array-> driverList
     */
    private $driverList;
    /**
     * Ayarları kullanır
     *
     * @param DriverInterface $driver
     * @param array $config
     */
    public function __construct(DriverInterface $driver = null, array $config = [])
    {
        $this->useDefaultVars();

        if (null !== $driver) {
            $this->driver($driver, $config);
        }
    }


    /**
     * Ön tanımlı değerleri kullanır.
     *
     */
    private function useDefaultVars()
    {
        $this->setDriverList([
            'local' => FileCache::class,
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
     * Sürücü seçimi yapar
     *
     * @param string $driver
     * @param array $configs
     * @throws DriverNotInstalledException
     * @return DriverAdapterInterface
     */
    public function driver($driver = '', array $configs = [])
    {
        $driverList = $this->getDriverList();

        if (!count($configs) & $driver === 'local') {

            $configs = [
                'folder' => ''
            ];
        }

        if (isset($driverList[$driver])) {
            $driver = $driverList[$driver];
        }

        if (is_string($driver)) {
            $driver = new $driver;
        }

        return $this->setDriver($driver, $configs);
    }

    /**
     * @param DriverInterface $driver
     * @param array $configs
     * @throws DriverNotInstalledException
     * @return DriverAdapterInterface
     */
    public function setDriver(DriverInterface $driver, array $configs = [])
    {


       $driver->boot($configs);

        if(true !== $driver->check())
        {
            throw new DriverNotInstalledException(sprintf('%s sürücünüz kullanıma hazır değil.', get_class($driver)));
        }


        return $this->adapter($driver);
    }

    /**
     * Driver olarak kullanıma hazırla
     *
     * @param DriverInterface $driver
     * @return DriverAdapterInterface
     */
    private function adapter(DriverInterface $driver)
    {

        return new DriverAdapter($driver);
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

}
