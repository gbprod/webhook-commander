<?php

namespace AppBundle\Shell;

/**
 * Shell
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class Shell
{
    /**
     * Execute the command
     *
     * @param string $command
     *
     * @return string execution trace
     */
    public function execute($command, $folder)
    {
        $previousFolder = getcwd();
        chdir($folder);
        $return = shell_exec($command);
        chdir($previousFolder);

        return $return;
    }
}