<?php


namespace Anonym\Components\Cache;

use Anonym\Components\Cache\Interfaces\DriverInterface;
use Anonym\Components\Cache\Interfaces\DriverAdapterInterface;
use Anonym\Components\Cache\Interfaces\FlushableInterface;

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
    private $data;

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


        $data = $this->data[$name];
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
            $this->data[$name] = [
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
        unset($this->data[$name]);
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
        return isset($this->data[$name]) || array_key_exists($name, $this->data);
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
        $this->data = [];
    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {
        $this->data = [];

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
