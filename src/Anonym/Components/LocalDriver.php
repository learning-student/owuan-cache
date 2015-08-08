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
class LocalDriver extends AbstractDriver implements DriverInterface, DriverAdapterInterface
{

    /**
     *Dosyanın yolunu tutar
     *
     *
     * @var string -> folder
     */
    private $folder;


    /**
     *Ayarların ne kadar süre tutulacağını tutar
     *
     *
     * @var int -> time
     */
    private $time = 3600;


    /**
     *Dosyanın uzantısını tutar
     *
     *
     * @var string -> ext
     */
    private $ext = '.cache';
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

        if (isset($config['time'])) {
            $this->setTime($config['time']);
        }

        if (isset($config['ext'])) {
            $this->setExt($config['ext']);
        }

        if (isset($config['folder'])) {

            $folder = $config['folder'];
            $this->setFolder($folder);
            if(!$this->getFileSystem()->exists($folder))
            {
                $this->getFileSystem()->createDir($folder);
                chmod($folder, 0777);
            }
        }else{

            return false;
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

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return LocalDriver
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     * @return LocalDriver
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @param string $ext
     * @return LocalDriver
     */
    public function setExt($ext)
    {
        $this->ext = $ext;
        return $this;
    }



    /**
     * Sınıfta kullanılmak üzere cache dosyalarının yolunu hazırlar
     *
     * @param $path
     * @return string
     */
    private function inPath($path)
    {

        $path =  $this->getFolder() . '/' . $path;
        return $path;
    }


    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {

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

    }

    /**
     * @param string $name Değer ismi
     * @return $this
     */
    public function delete($name)
    {

    }

    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush()
    {

    }

    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists($name)
    {

    }
}
