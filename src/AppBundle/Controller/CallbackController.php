<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller for callback
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackController extends Controller implements WebhookController
{
    public function __construct()
    {

    }

    public function callback()
    {
        return Response::create(null, Response::HTTP_NO_CONTENT);
    }
}
