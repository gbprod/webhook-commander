<?php

namespace AppBundle\Trigger;

/**
 * Trigger
 *
 * @author gbprod <contact@gb-prod.fr>
 */
final class Trigger
{
    /**
     * @var string
     */
    private $repository;

    /**
     * @var string
     */
    private $branch;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $command;

    /**
     * Create new trigger
     *
     * @param string $repository
     * @param string $branch
     * @param string $path
     * @param string $command
     *
     * @return Trigger
     */
    public static function create($repository, $branch, $path, $command)
    {
        return new self($repository, $branch, $path, $command);
    }

    private function __construct($repository, $branch, $path, $command)
    {
        $this->repository = $repository;
        $this->branch = $branch;
        $this->path = $path;
        $this->command = $command;
    }

    /**
     * Gets the repository
     *
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Gets the branch
     *
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Gets the path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Gets the command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }
}