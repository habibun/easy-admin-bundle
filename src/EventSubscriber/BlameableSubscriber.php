<?php

namespace App\EventSubscriber;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class BlameableSubscriber implements EventSubscriberInterface
{
    private Security $security;

    /**
     * {@inheritDoc}
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onBeforeEntityUpdatedEvent(BeforeEntityUpdatedEvent $event)
    {
        $location = $event->getEntityInstance();

        if (!$location instanceof Location) {
            return;
        }

        $user = $this->security->getUser();

        $location->setUpdatedBy($user);
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityUpdatedEvent::class => 'onBeforeEntityUpdatedEvent',
        ];
    }
}
