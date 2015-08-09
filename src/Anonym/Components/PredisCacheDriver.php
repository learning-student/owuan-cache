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
 */
class PredisCacheDriver implements DriverAdapterInterface, DriverInterface
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
    public function get($name)
    {
        // TODO: Implement get() method.
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
        // TODO: Implement set() method.
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete($name)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists($name)
    {
        // TODO: Implement exists() method.
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
     * @throws PredisClientException
     * @return mixed
     */
    public function boot(array $configs = [])
    {
        try{
            $redis = new PredisClient($configs);
        }catch (Exception $e)
        {
            throw new PredisClientException('Predis sınıfınız düzgün olarak başlatılamadı');
        }

    }
}
