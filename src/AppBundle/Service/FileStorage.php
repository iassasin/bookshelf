<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Psr\Container\ContainerInterface;

class FileStorage
{
    private $targetDir;
    private $filesystem;
    private $container;

    public function __construct($targetDir, Filesystem $filesystem, ContainerInterface $container)
    {
        $this->targetDir = $targetDir;
        $this->filesystem = $filesystem;
        $this->container = $container;
    }

    public function upload(UploadedFile $file)
    {
        $baseDir = $this->getTargetDir().'/';

        $fileName = sha1(uniqid()).'.'.($file->guessExtension() ?? '.bin');
        $f1 = '/'.$fileName[0];
        $f2 = '/'.$fileName[1];

        if (!$this->filesystem->exists($baseDir.$f1)) {
            $this->filesystem->mkdir($baseDir.$f1);
        }
        if (!$this->filesystem->exists($baseDir.$f1.$f2)) {
            $this->filesystem->mkdir($baseDir.$f1.$f2);
        }

        $file->move($baseDir.$f1.$f2, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        if ($fileName != '') {
            $path = $this->getFilePathByFileName($fileName);
            if ($this->filesystem->exists($path)) {
                $this->filesystem->remove($path);
            }
        }
    }

    public function getFilePathByFileName($fileName)
    {
        return strlen($fileName) < 2
            ? $fileName
            : $this->getTargetDir().'/'.$fileName[0].'/'.$fileName[1].'/'.$fileName;
    }

    public function getAssetFilePath($fileName)
    {
        $kernelDir = $this->container->getParameter('web_directory');
        $path = $this->getFilePathByFileName($fileName);
        return str_replace($kernelDir, '', $path);
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
