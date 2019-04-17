<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Cache;

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
        return apc_fetch($name);
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
        return apc_add($name, $value, $time);
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
    public function exists($name) : bool
    {
        $response =  apc_exists($name);

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
