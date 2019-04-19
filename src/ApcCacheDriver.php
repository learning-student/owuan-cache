<?php


namespace Anonym\Components\Cache;

use Anonym\Components\Cache\Interfaces\DriverInterface;
use Anonym\Components\Cache\Interfaces\DriverAdapterInterface;

/**
 * Class ApcCacheDriver
 * @package Anonym\Components\Cache
 */
class ApcCacheDriver implements DriverInterface, DriverAdapterInterface
{

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return unserialize(apc_fetch($name), [
            'allowed_clases' => true
        ]);
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
        return apc_add($name, serialize($value), $time);
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        $response = apc_delete($name);

        return is_bool($response) ? $response : true;
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        return apc_clear_cache();
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        $response = apc_exists($name);

        return is_bool($response) ? $response : true;
    }

    /**
     *Apc cache in kurulu olup olmadığına bakar
     *
     * @return bool
     */
    public function check()
    {
        return function_exists('apc_fetch');
    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        // we dont have to something
    }
}
