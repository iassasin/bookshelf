<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Entity\Book;
use AppBundle\Service\FileStorage;

class BookSubscriber implements EventSubscriber
{
    private $storage;
    private $filesystem;

    public function __construct(FileStorage $storage, Filesystem $filesystem)
    {
        $this->storage = $storage;
        $this->filesystem = $filesystem;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postLoad,
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
            Events::postFlush,
        ];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->loadFiles($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->loadFiles($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->removeFiles($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->loadFiles($args);
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $cacheDriver = $em->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('all_books');
    }

    public function loadFiles(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Book) {
            if ($entity->getCoverPath() != '') {
                $path = $this->storage->getFilePathByFileName($entity->getCoverPath());
                if ($this->filesystem->exists($path)) {
                    $entity->setCoverFile(new File($path));
                }
            } else {
                $entity->setCoverFile(null);
            }

            if ($entity->getBookPath() != '') {
                $path = $this->storage->getFilePathByFileName($entity->getBookPath());
                if ($this->filesystem->exists($path)) {
                    $entity->setBookFile(new File($path));
                }
            } else {
                $entity->setBookFile(null);
            }
        }
    }

    public function removeFiles(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Book) {
            if ($entity->getCoverPath() != '') {
                $this->storage->remove($entity->getCoverPath());
            }

            if ($entity->getBookPath() != '') {
                $this->storage->remove($entity->getBookPath());
            }
        }
    }
}
