<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadýr.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Cache;

/**
 * Class AbstractDriver
 * @package Anonym\Components\Cache
 */
abstract class AbstractDriver
{

    /**
     *ayarlarý tutar
     *
     *
     * @var  -> config
     */
    private $config;

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return AbstractDriver
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }


}