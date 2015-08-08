<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */


namespace Anonym\Components\Cache;

use Anonym\Components\Filesystem\Filesystem;
use Anonym\Components\Filesystem\FilesystemAdapter;

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
     * @var  FilesystemAdapter-> fileSystem
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
            if(!$this->getFileSystem()->exists($folder))
            {
                $this->getFileSystem()->createDir($folder);
                chmod($folder, 0777);
            }
        }

        // we dont need do something else
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
        $this->setConfig($configs);
        $this->setFileSystem((new Filesystem())->disk('local'));
    }

    /**
     * @return FilesystemAdapter
     */
    public function getFileSystem()
    {
        return $this->fileSystem;
    }

    /**
     * @param FilesystemAdapter $fileSystem
     * @return LocalDriver
     */
    public function setFileSystem(FilesystemAdapter $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        return $this;
    }


}
