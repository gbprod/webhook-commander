<?php

namespace AppBundle\Trigger;

/**
 * In memory trigger repository implementation
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class InMemoryTriggerRepository implements TriggerRepository
{
    /**
     * @var array
     */
    private $triggers;

    /**
     * @param array|null $triggers
     */
    public function __construct(array $triggers = null)
    {
        $this->triggers = array_map(
            function($trigger) {
                return Trigger::create(
                    $trigger['repository'],
                    $trigger['branch'],
                    $trigger['path'],
                    $trigger['command']
                );
            },
            $triggers ?: array()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function findMatching($repository, $branch)
    {
        return array_values(
            array_filter(
                $this->triggers,
                function ($trigger) use ($repository, $branch) {
                    return $trigger->getRepository() == $repository
                        && $trigger->getBranch() == $branch
                    ;
                }
            )
        );
    }
}