<?php

namespace AppBundle\Webhook\Validator;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for webhook requests
 *
 * @author gbprod <contact@gb-prod.fr>
 */
interface Validator
{
    /**
     * Validate the request
     *
     * @param Request $request
     *
     * @return bool
     */
    public function validate(Request $request);
}