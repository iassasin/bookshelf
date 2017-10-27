<?php

namespace AppBundle\Twig;

use Symfony\Component\Asset\Packages;
use Psr\Container\ContainerInterface;
use AppBundle\Service\FileStorage;

class AppExtension extends \Twig_Extension
{
    /** @var Packages */
    private $assets;
    /** @var ContainerInterface */
    private $container;
    /** @var FileStorage */
    private $storage;

    public function __construct(Packages $assets, ContainerInterface $container, FileStorage $storage)
    {
        $this->assets = $assets;
        $this->container = $container;
        $this->storage = $storage;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('sized_image', [$this, 'sizedImageFunction'], ['is_safe' => ['html']]),
            new \Twig_Function('storage_file_path', [$this, 'storageFilePathFunction']),
        ];
    }

    public function sizedImageFunction($path, $width = null, $height = 100)
    {
        $css = "height: ${height}px;";
        if ($width !== null) {
            $css .= "width: ${width}px;";
        }

        return "<img style=\"$css\" src=\"".$this->assets->getUrl($path)."\">";
    }

    public function storageFilePathFunction($fileName)
    {
        $kernelDir = $this->container->getParameter('web_directory');
        $path = $this->storage->getFilePathByFileName($fileName);
        return str_replace($kernelDir, '', $path);
    }
}
