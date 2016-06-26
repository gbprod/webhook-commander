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
     * @param array $triggers
     */
    public function __construct(array $triggers = null)
    {
        $this->triggers = $triggers ?: array();
    }

    /**
     * {@inheritDoc}
     */
    public function findMatching($repository, $branch)
    {
        return array_values(array_filter(
            array_map(
                function($trigger) use ($repository, $branch) {
                    if ($trigger['repository'] == $repository && $trigger['branch'] == $branch) {
                        return Trigger::create(
                            $trigger['repository'],
                            $trigger['branch'],
                            $trigger['path'],
                            $trigger['command']
                        );
                    }
                },
                $this->triggers
            )
        ));
    }
}