<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Psr\Container\ContainerInterface;
use AppBundle\Service\FileStorage;

class SerializeBookSubscriber implements EventSubscriberInterface
{
    /** @var FileStorage */
    private $storage;
    /** @var ContainerInterface */
    private $container;
    /** @var RequestStack */
    private $requestStack;

    public function __construct(FileStorage $storage, ContainerInterface $container, RequestStack $requestStack)
    {
        $this->storage = $storage;
        $this->container = $container;
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => 'serializer.post_serialize',
                'class' => 'AppBundle\Entity\Book',
                'method' => 'onPostSerializeBook',
            ],
        ];
    }

    public function onPostSerializeBook(ObjectEvent $event)
    {
        $book = $event->getObject();
        $serBook = $event->getVisitor();

        $request = $this->requestStack->getCurrentRequest();

        if ($serBook->hasData('cover_path') && $book->getCoverPath() != '') {
            $coverPath = $this->storage->getAssetFilePath($book->getCoverPath());
            $serBook->setData('cover_path', $request->getUriForPath($coverPath));
        }

        if ($serBook->hasData('book_path') && $book->getIsDownloadable() && $book->getBookPath() != '') {
            $bookPath = $this->storage->getAssetFilePath($book->getBookPath());
            $serBook->setData('book_path', $request->getUriForPath($bookPath));
        }
    }
}
