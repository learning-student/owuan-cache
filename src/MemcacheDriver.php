<?php


namespace Anonym\Components\Cache;

use Memcache;
use Anonym\Components\Cache\Interfaces\DriverInterface;
use Anonym\Components\Cache\Interfaces\DriverAdapterInterface;
use Anonym\Components\Cache\Interfaces\FlushableInterface;

/**
 * the driver of memcache
 *
 * Class MemcacheDriver
 * @package Anonym\Components\Cache
 */
class MemcacheDriver implements DriverInterface,
    DriverAdapterInterface,
    FlushableInterface
{

    /**
     * Memcache objesini tutar
     *
     *
     * @var  \Memcache-> driver
     */
    private $driver;

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $value =  $this->getDriver()->get($name);

        return unserialize($value, [
            'allowed_clases' => true
        ]);
    }


    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return mixed
     */
    public function set(string $name, $value, int $time = 3600) : bool
    {

        return $this->getDriver()->add($name, $value, false, $time);
    }

    /**
     * @param string $name Değer ismi
     * @return bool
     */
    public function delete(string $name): bool
    {
        return $this->getDriver()->delete($name);
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        return $this->getDriver()->flush();
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        return (bool)$this->getDriver()->get($name);
    }

    /**
     *Memcache sürücüsünün yüklü olup olmadığını kontrol eder
     *
     * @return bool
     */
    public function check()
    {

        if (extension_loaded('memcache')) {
            return true;
        }

    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        $host = $configs['host'] ?? '127.0.0.1';
        $port = $configs['port'] ?? 11211;

        $memcache = new Memcache();
        $memcache->connect($host, $port);
        $this->setDriver($memcache);
    }

    /**
     * get the memcache driver
     *
     * @return Memcache
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param Memcache $driver
     * @return MemcacheDriver
     */
    public function setDriver(Memcache $driver)
    {
        $this->driver = $driver;
        return $this;
    }
}
