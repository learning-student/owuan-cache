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
 * Class LocalDriver
 * @package Anonym\Components\Caches
 */
class LocalDriver extends AbstractDriver implements DriverInterface
{

    /**
     *
     *
     *
     * @var  -> fileSystem
     */
    private $fileSystem;

    /**
     * Kontrol eder
     *
     * @return bool
     */
    public function check()
    {

        $config = $this->getConfig();

        if (isset($config['folder'])) {

            $folder = $config['folder'];

        }

        // we dont need do something
        return true;
    }

    /**
     * Ayarlarý kullanýr ve bazý baþlangýç iþlemlerini gerçekleþtirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = [])
    {

        $this->setConfig($configs);
    }
}
