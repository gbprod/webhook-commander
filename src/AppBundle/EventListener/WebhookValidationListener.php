<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\WebhookController;
use AppBundle\Webhook\Validator\Validator;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Listener for Webhook validation
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class WebhookValidationListener
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Listen to kernel controller event
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller) || !$controller[0] instanceof WebhookController) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->validator->validate($request)) {
            throw new AccessDeniedHttpException();
        }
    }
}