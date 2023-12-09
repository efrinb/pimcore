<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SessionBagListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            //run after Symfony\Component\HttpKernel\EventListener\SessionListener
            KernelEvents::REQUEST => ['onKernelRequest', 127],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        if ($event->getRequest()->attributes->get('_stateless', false)) {
            return;
        }

        $session = $event->getRequest()->getSession();

        //do not register bags, if session is already started
        if ($session->isStarted()) {
            return;
        }

        $bag = new AttributeBag('_session_cart');
        $bag->setName('session_cart');

        $session->registerBag($bag);
    }
}

