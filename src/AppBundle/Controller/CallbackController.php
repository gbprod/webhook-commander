<?php

namespace AppBundle\Controller;

use AppBundle\Webhook\Handler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for callback
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackController extends Controller implements WebhookController
{
    /**
     * @var Handler
     */
    private $handler;

    /**
     * @param Handler $handler
     */
    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Callback action
     *
     * @param Request $request
     *
     * @return Response
     */
    public function callback(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $this->handler->handle($payload);

        return Response::create(null, Response::HTTP_NO_CONTENT);
    }
}
