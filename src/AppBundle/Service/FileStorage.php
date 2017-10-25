<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileStorage
{
    private $targetDir;

    public function __construct($targetDir) {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fs = new Filesystem();
        $baseDir = $this->getTargetDir();

        $fileName = sha1(uniqid()).'.'.($file->guessExtension() ?? '.bin');
        $f1 = '/'.$fileName[0];
        $f2 = '/'.$fileName[1];

        if (!$fs->exists($baseDir.$f1)) {
            $fs->mkdir($baseDir.$f1);
        }
        if (!$fs->exists($baseDir.$f1.$f2)) {
            $fs->mkdir($baseDir.$f1.$f2);
        }

        $file->move($baseDir.$f1.$f2, $fileName);

        return $fileName;
    }

    public function getFilePathByFileName($fileName) {
        return $this->getTargetDir().'/'.$fileName[0].'/'.$fileName[1].'/'.$fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
