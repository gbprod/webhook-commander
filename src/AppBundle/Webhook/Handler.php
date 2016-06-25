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

        $repository = $this->repository->findMatching($respository, $branch);

        foreach($repository as $trigger) {
            $this->shell->execute(
                $trigger->getCommand(),
                $trigger->getPath()
            );
        }
    }

    public function extract(array $payload)
    {
        $repository = $payload['repository']['full_name'];
        $branch = preg_replace('#refs/heads/#', '', $payload['ref']);

        return [$repository, $branch];
    }
}