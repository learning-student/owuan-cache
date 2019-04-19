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
 * Class ArrayCacheDriver
 * @package Anonym\Components\Cache
 */
class ArrayCacheDriver implements DriverAdapterInterface,
    DriverInterface,
    FlushableInterface
{

    /**
     * Verileri depolar
     *
     *
     * @var array -> data
     */
    private static $data;

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {

        // return null if data does not exists
        if (!$this->exists($name)) {
            return null;
        }


        $data = static::$data[$name];
        $current = (new \DateTime())->getTimestamp();

        if ($data && $data['end_time'] > $current) {
            return $data['value'];
        }

        // because end_time has ended and we don't need to use it anymore
        $this->delete($name);

        return false;
    }

    /**
     * Veri ataması yapar
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return bool
     * @throws \Exception
     */
    public function set(string $name, $value, int $time = 3600): bool
    {

        try {
            // current timestamp
            $end = (new \DateTime("+$time seconds"))->getTimestamp();
            static::$data[$name] = [
                'value' => $value,
                'end_time' => $end
            ];

        } catch (\Exception $exception) {
            return false;
        }


        return true;
    }

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool
    {
        unset(static::$data[$name]);
        return true;
    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists($name): bool
    {
        return isset(static::$data[$name]) || array_key_exists($name, static::$data);
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
     */
    public function boot(array $configs = [])
    {

        // do it array
        static::$data = [];
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        static::$data = [];
        return $this;
    }

    /**
     * @return array
     */
    public static function getData()
    {
        return self::$data;
    }

    /**
     * @param array $data
     */
    public static function setData($data)
    {
        self::$data = $data;
    }
}
