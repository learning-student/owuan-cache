<?php


namespace Anonym\Components\Cache;


/**
 * Class Cache
 * @package Anonym\Components\Cache
 */
class Cache extends ConfigRepository implements CacheInterface, DriverAdapterInterface
{

    /**
     * Sürüclerin listesini tutar
     *
     *
     * @var  array-> driverList
     */
    private $driverList;

    /**
     *
     * @param array $config
     * @param DriverInterface|DriverAdapterInterface $driver
     * @throws DriverNotInstalledException
     */
    public function __construct(array $config = [], DriverAdapterInterface $driver = null)
    {
        $this->useDefaultVars();
        $this->setConfig($config);


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
            'file' => FileCacheDriver::class,
            'memcache' => MemcacheDriver::class,
            'redis' => RedisCacheDriver::class,
            'xcache' => XCacheDriver::class,
            'zend' => ZendDataCache::class,
            'predis' => PredisCacheDriver::class,
            'apc' => ApcCacheDriver::class,
            'array' => ArrayCacheDriver::class
        ]);
    }

    /**
     * @return DriverAdapterInterface
     */
    public function getDriver(): DriverAdapterInterface
    {
        return $this->driver;
    }

    /**
     * Sürücü seçimi yapar
     *
     * @param string $driver
     * @param array $configs
     * @return DriverAdapterInterface
     * @throws DriverNotInstalledException
     */
    public function driver($driver = '', array $configs = []): DriverAdapterInterface
    {
        $driverList = $this->getDriverList();

        if (!count($configs)) {
            $configs = $this->getConfig()[$driver] ?? [];
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
     * @return DriverAdapterInterface
     * @throws DriverNotInstalledException
     */
    public function setDriver(DriverInterface $driver, array $configs = []): DriverAdapterInterface
    {


        $driver->boot($configs);

        if (true !== $driver->check()) {
            throw new DriverNotInstalledException(sprintf('%s driver is not installed yet ', get_class($driver)));
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
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->getDriver()->get($name);
    }

    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return mixed
     */
    public function set(string $name, $value, int $time = 3600)
    {
        $this->getDriver()->set($name, $value, $time);
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        return $this->getDriver()->delete($name);
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        return $this->getDriver()->delete($name);
    }
}
