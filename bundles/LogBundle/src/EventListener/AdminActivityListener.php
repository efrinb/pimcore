<?php

namespace LogBundle\EventListener;

use Pimcore\Http\Request\Resolver\PimcoreContextResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Pimcore\Security\User\TokenStorageUserResolver;
use Pimcore\Bundle\CoreBundle\EventListener\Traits\PimcoreContextAwareTrait;
use LogBundle\Model\Activity;

class AdminActivityListener implements EventSubscriberInterface
{
    use PimcoreContextAwareTrait;
    private $logger;
    protected TokenStorageUserResolver $userResolver;

    public function __construct(TokenStorageUserResolver $userResolver, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->userResolver = $userResolver;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$event->isMainRequest()) {
            return;
        }

        if (!$this->matchesPimcoreContext($request, PimcoreContextResolver::CONTEXT_ADMIN)){
            return;
        }

        $logEntry = new Activity();
        $user = $this->userResolver->getUser();
        $timestamp = new \DateTime();
        $time = $timestamp->format('Y-m-d H:i:s');
        $logEntry->setTimestamp($time);
        $logEntry->setAction($request->attributes->get('_controller'));
        $logEntry->setUserId($user ? $user->getId(): 'NA');
        $logEntry->save();
    }

    protected function getParams(Request $request): array
    {
        $params = [];
        $disallowedKeys = ['_dc', 'module', 'controller', 'action', 'password'];

        $requestParams = array_merge(
            $request->query->all(),
            $request->request->all()
        );

        foreach ($requestParams as $key => $value) {
            if (is_json($value)) {
                $value = json_decode($value);
                if (is_array($value)) {
                    array_walk_recursive($value, function (&$item, $key) {
                        if (strpos((string)$key, 'pass') !== false) {
                            $item = '*************';
                        }
                    });
                }

                $value = json_encode($value);
            }

            if (!in_array($key, $disallowedKeys) && is_string($value)) {
                $params[$key] = (strlen($value) > 40) ? substr($value, 0, 40) . '...' : $value;
            }
        }

        return $params;
    }
}
