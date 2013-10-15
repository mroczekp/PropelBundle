<?php

/**
 * This file is part of the PropelBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Propel\PropelBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Propel\Generator\Command\MigrationUpCommand as BaseCommand;

/**
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class MigrationUpCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('propel:migration:up')
            ->setDescription('Execute migrations up')

            ->addOption('connection',       null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Connection to use. Example: default, bookstore')
            ->addOption('migration-table',  null, InputOption::VALUE_REQUIRED,  'Migration table name', BaseCommand::DEFAULT_MIGRATION_TABLE)
            ->addOption('output-dir',       null, InputOption::VALUE_OPTIONAL,  'The output directory')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $defaultOutputDir = $this->getApplication()->getKernel()->getRootDir().'/propel/migrations';

        $this->setupBuildTimeFiles();

        $params = array(
            '--connection'      => $this->getConnections($input->getOption('connection')),
            '--migration-table' => $input->getOption('migration-table'),
            '--output-dir'      => $input->getOption('output-dir') ?: $defaultOutputDir,
        );

        return $this->runCommand(new BaseCommand(), $params, $input, $output);
    }
}
