<?php
namespace App\EventSubscriber;

use App\Controller\TestController;
use App\Security\Exception\NotValidTokenException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TestController) {
            $sessionToken = $event->getRequest()->getSession()->get("access_token");
            $requestToken = str_replace("Bearer ", "", $event->getRequest()->headers->get('authorization'));
            if (!$requestToken || $sessionToken !== str_replace("Bearer ", "", $requestToken)) {
                throw new NotValidTokenException();
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}