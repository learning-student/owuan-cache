<?php


namespace Anonym\Components\Cache;

use Anonym\Components\Cache\Interfaces\DriverInterface;
use Anonym\Components\Cache\Interfaces\DriverAdapterInterface;
use Anonym\Components\Cache\Interfaces\FlushableInterface;

/**
 * Class ZendDataCache
 * @package Anonym\Components\Cache
 */
class ZendDataCache implements DriverAdapterInterface,
    DriverInterface,
    FlushableInterface
{

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $value = zend_shm_cache_fetch($name);

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
    public function set(string $name, $value, int $time = 3600): bool
    {
        return (bool)zend_shm_cache_store($name, serialize($value), $time);
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        return zend_shm_cache_delete($name);
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        return zend_shm_cache_clear();
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        return (false !== $this->get($name));
    }

    /**
     * Zend data cache in kurulu olup olmadığını kontrol eder
     *
     * @return bool
     */
    public function check()
    {
        return function_exists('zend_shm_cache_fetch');
    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        //
    }
}
