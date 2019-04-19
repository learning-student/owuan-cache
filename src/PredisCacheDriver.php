<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Cache;

use Exception;
use Predis\Client as PredisClient;

/**
 * Class PredisCacheDriver
 * @package Anonym\Components\Cache
 * predis/predis package need to be installed in order to use this package
 */
class PredisCacheDriver implements DriverAdapterInterface,
    DriverInterface,
    FlushableInterface
{

    /**
     * Predis objesini tutar
     *
     *
     * @var  PredisClient-> predis
     */
    private $predis;

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        $value = $this->getPredis()->get($name);

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
     * @return bool
     */
    public function set(string $name, $value, int $time = 3600): bool
    {
        return $this->getPredis()->set($name,
            serialize($value),
            null,
            $time);
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        return (bool)$this->getPredis()->del($name);
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        return $this->getPredis()->flushall();
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool
    {
        return $this->getPredis()->exists($name);
    }

    /**
     *
     *
     * @return bool
     */
    public function check()
    {
        return true;
    }

    /**
     * Ayarları kullanır ve bazı başlangıç işlemlerini gerçekleştirir
     *
     * @param array $configs
     * @return mixed
     * @throws PredisClientException
     */
    public function boot(array $configs = [])
    {
        try {
            $redis = new PredisClient($configs);
        } catch (Exception $e) {
            throw new PredisClientException('Predis sınıfınız düzgün olarak başlatılamadı');
        }

        $this->setPredis($redis);
    }

    /**
     * @return PredisClient
     */
    public function getPredis()
    {
        return $this->predis;
    }

    /**
     * @param PredisClient $predis
     * @return PredisCacheDriver
     */
    public function setPredis(PredisClient $predis)
    {
        $this->predis = $predis;
        return $this;
    }
}
