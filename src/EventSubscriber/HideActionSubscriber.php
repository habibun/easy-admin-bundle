<?php

namespace App\EventSubscriber;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HideActionSubscriber implements EventSubscriberInterface
{
    public function onBeforeCrudActionEvent(BeforeCrudActionEvent $event)
    {
        if (!$adminContext = $event->getAdminContext()) {
            return;
        }
        if (!$crudDto = $adminContext->getCrud()) {
            return;
        }
        if (Location::class !== $crudDto->getEntityFqcn()) {
            return;
        }

        // disable action entirely delete, detail, edit
        $question = $adminContext->getEntity()->getInstance();
        if ($question instanceof Location && $question->getEnabled()) {
            $crudDto->getActionsConfig()->disableActions([Action::DELETE]);
        }

        // This gives you the "configuration for all the actions".
        // Calling ->getActions() returns the array of actual actions that will be
        // enabled for the current page... so then we can modify the one for "delete"
        $actions = $crudDto->getActionsConfig()->getActions();
        if (!$deleteAction = $actions[Action::DELETE] ?? null) {
            return;
        }
        $deleteAction->setDisplayCallable(function (Location $question) {
            return !$question->getEnabled();
        });
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeCrudActionEvent::class => 'onBeforeCrudActionEvent',
        ];
    }
}
