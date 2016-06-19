<?php

namespace AppBundle\Webhook\Validator;

use Symfony\Component\HttpFoundation\Request;

/**
 * Validator for Github Webhook
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class GithubValidator implements Validator
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(Request $request)
    {
        $signature = $request->headers->get('X-Hub-Signature', null);
        if (null === $signature) {
            return false;
        }

        list($algorithm, $sentHash) = explode('=', $signature);
        if ($algorithm !== 'sha1') {
            return false;
        }

        $payload = $request->getContent();
        $generatedHash = hash_hmac($algorithm, $payload, $this->secret);

        return ($generatedHash === $sentHash);
    }
}
