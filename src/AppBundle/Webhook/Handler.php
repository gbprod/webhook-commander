<?php

namespace AppBundle\Webhook;

use AppBundle\Trigger\TriggerRepository;
use AppBundle\Shell\Shell;

/**
 * Webhook handler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class Handler
{
    /**
     * @var TriggerRepository
     */
    private $repository;

    /**
     * @var Shell
     */
    private $shell;

    /**
     * @param TriggerRepository $repository
     * @param Shell $shell
     */
    public function __construct(TriggerRepository $repository, Shell $shell)
    {
        $this->repository = $repository;
        $this->shell = $shell;
    }

    /**
     * Handle webhook payload
     *
     * @param array $payload
     */
    public function handle(array $payload)
    {
        list($respository, $branch) = $this->extract($payload);

        $triggers = $this->repository->findMatching($respository, $branch);

        foreach($triggers as $trigger) {
            $this->shell->execute(
                $trigger->getCommand(),
                $trigger->getPath()
            );
        }
    }

    private function extract(array $payload)
    {
        if ($this->isInvalidPayload($payload)) {
            throw new \InvalidArgumentException();
        }

        $repository = $payload['repository']['full_name'];
        $branch = preg_replace('#refs/heads/#', '', $payload['ref']);

        return [$repository, $branch];
    }

    private function isInvalidPayload(array $payload)
    {
        return !isset($payload['repository']['full_name'])
            || !isset($payload['ref'])
        ;
    }
}