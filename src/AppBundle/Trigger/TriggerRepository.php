<?php

namespace AppBundle\Trigger;

/**
 * Interface for trigger repository
 *
 * @author gbprod <contact@gb-prod.fr>
 */
interface TriggerRepository
{
    /**
     * Find matching triggers
     *
     * @param string $repository
     * @param string $branch
     *
     * @return array<Trigger>
     */
    public function findMatching($repository, $branch);
}