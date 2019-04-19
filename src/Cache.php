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
     * @var  DriverAdapterInterface
     */
    private $driver;

    /**
     *
     * @param array $config
     * @param DriverInterface|DriverAdapterInterface $driver
     * @throws DriverNotInstalledException
     */
    public function __construct(array $config = [], string $driver = null)
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

        $driver = new $driver;

        return $this->setDriver($driver, $configs);
    }

    /**
     * @param DriverInterface $driver
     * @param array $configs
     * @return DriverAdapterInterface
     * @throws DriverNotInstalledException
     */
    public function setDriver(DriverAdapterInterface $driver, array $configs = []): DriverAdapterInterface
    {


        $driver->boot($configs);

        if (true !== $driver->check()) {
            throw new DriverNotInstalledException(sprintf('%s driver is not installed yet ', get_class($driver)));
        }


        return $this->driver = $driver;
    }


    /**
     * @return array
     */
    public function getDriverList(): array
    {
        return $this->driverList;
    }

    /**
     * @param array $driverList
     * @return Cache
     */
    public function setDriverList(array $driverList): Cache
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
        try {
            return $this->getDriver()->get($name);
        } catch (\Exception $exception) {
            return false;
        }

    }

    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return bool
     */
    public function set(string $name, $value, int $time = 3600): bool
    {

        try {
            return $this->getDriver()->set($name, $value, $time);
        } catch (\Exception $exception) {
            return false;
        }


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
        return $this->getDriver()->exists($name);
    }
}
