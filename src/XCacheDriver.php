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
 * Class XCacheDriver
 * @package Anonym\Components\Cache
 */
class XCacheDriver implements DriverInterface,
    DriverAdapterInterface,
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
        return xcache_get($name);
    }

    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return bool
     */
    public function set(string $name, $value, int $time = 3600) : bool
    {
        return xcache_set($name, $value, $time);
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        return xcache_unset($name);
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        $count = xcache_count(XC_TYPE_PHP);
        for ($i = 0; $i < $count; $i++) {
            // XCache PHP cache temizle.
            xcache_clear_cache(XC_TYPE_PHP, $i);
        }

        $count = xcache_count(XC_TYPE_VAR);
        for ($i = 0; $i < $count; $i++) {
            // XCache degisken cache temizle.
            xcache_clear_cache(XC_TYPE_VAR, $i);
        }

        return true;
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        return xcache_isset($name);
    }

    /**
     *Xcache sürücüsünün olup olmadığını kontrol ediyoruz
     *
     * @return bool
     */
    public function check()
    {
        return function_exists('xcache_set');
    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        // we not have do somethink
    }
}
