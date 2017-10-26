<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileStorage
{
    private $targetDir;
    private $filesystem;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
        $this->filesystem = new Filesystem();
    }

    public function upload(UploadedFile $file)
    {
        $baseDir = $this->getTargetDir();

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
        $path = $this->getFilePathByFileName($fileName);
        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }
    }

    public function getFilePathByFileName($fileName)
    {
        return $this->getTargetDir().'/'.$fileName[0].'/'.$fileName[1].'/'.$fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
