<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Cache;
use Redis;

/**
 * Class RedisCacheDriver
 * @package Anonym\Components\Cache
 */
class RedisCacheDriver implements DriverAdapterInterface,DriverInterface
{

    /**
     *Redis nesnesini tutar
     *
     *
     * @var Redis -> redis
     */
    private $redis;
    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->getRedis()->get($name);
    }

    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return mixed
     */
    public function set($name, $value, $time = 3600)
    {
        return $this->getRedis()->set($name, $value, $time);
    }

    /**
     * @param string $name Değer ismi
     * @return bool
     */
    public function delete($name)
    {
        return $this->getRedis()->delete($name);
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        return $this->getRedis()->flushAll();
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return $this->getRedis()->exists($name);
    }

    /**
     *
     *
     * @return bool
     */
    public function check()
    {
        return extension_loaded('redis');
    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        $host = $configs['host'];
        $port = $configs['port'];
        $timeOut = $configs['timeout'];
        $redisObj = new Redis();
        $redisObj->connect($host, $port, $timeOut);
        $redisObj->setOption(Redis::OPT_SERIALIZER,
            Redis::SERIALIZER_PHP);    // use built-in serialize/unserialize

        $this->setRedis($redisObj);
    }

    /**
     * @return Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @param Redis $redis
     * @return RedisCacheDriver
     */
    public function setRedis(Redis $redis)
    {
        $this->redis = $redis;
        return $this;
    }


}
