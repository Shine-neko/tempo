<?php

/*
 * This file is part of the Tempo-project package http://tempo-project.org/>.
 *
 * (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tempo\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class EnvInfoCommand extends ContainerAwareCommand
{
    const REQUIRED_PHP_VERSION = '5.5.0';
    const REQUIRED_REDIS_VERSION = '2.0.0';
    const REQUIRED_NODEJS_VERSION = '0.12.2';
    const REQUIRED_NPM_VERSION = '2.9.0';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->setName('tempo:env:info')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $installedPhpVersion = phpversion();
        $output->writeln('PHP version >= '.self::REQUIRED_PHP_VERSION.'? ... ');

        if (version_compare(phpversion(), self::REQUIRED_REDIS_VERSION, '<')) {
            $output->writeln(sprintf(
                'You are running PHP version "<strong>%s</strong>", but Tempo needs at least PHP "<strong>%s</strong>" to run.',
                 $installedPhpVersion, self::REQUIRED_PHP_VERSION
            ));
        } else {
            $output->writeln(sprintf('<info>yes. You are running PHP version "%s"</info>', $installedPhpVersion));
        }

        // NODEJS

        $nodeProcess = new Process('node -v');
        $nodeProcess->run();
        $nodeVersion = trim(str_replace(['v', ''],'', $nodeProcess->getOutput()));
        $output->writeln('NodeJS version >= '.self::REQUIRED_NODEJS_VERSION.'? ... ');

        if (version_compare($nodeVersion, self::REQUIRED_NODEJS_VERSION, '<')) {
            $output->writeln(sprintf(
                '<error>No. You are running Update your NodeJS to a version >= "%s"</error>',
                $nodeVersion, self::REQUIRED_NODEJS_VERSION
            ));
        } else {
            $output->writeln(sprintf('<info>yes. You are running NodeJS version "%s"</info>', $nodeVersion));
        }

        // NPM
        $npmProcess = new Process('npm -v');
        $npmProcess->run();
        $npmVersion = trim(str_replace(['v', ''],'', $npmProcess->getOutput()));
        $output->writeln('NPM version >= '.self::REQUIRED_NPM_VERSION.'? ...');

        if (version_compare($npmVersion, self::REQUIRED_NPM_VERSION, '<')) {
            $output->writeln(sprintf(
                '<error>No. You are running %s. Update your NPM to a version >= "%s"</error>',
                $npmVersion, self::REQUIRED_NPM_VERSION
            ));
        } else {
            $output->writeln(sprintf('<info>yes. You are running NPM version "%s"</info>', $npmVersion));
        }

        // REDIS
        $redisProcess = new Process('redis-cli --version');
        $redisProcess->run();
        $redisVersion = str_replace('redis-cli ','', $redisProcess->getOutput());
        $output->writeln('Redis version >= '.self::REQUIRED_REDIS_VERSION.'? ... ');

        if (version_compare($redisVersion, self::REQUIRED_REDIS_VERSION, '<')) {
            $output->writeln(sprintf(
                '<error>No. You are running Update your Redis server to a version >= "%s"</error>',
                $redisVersion, self::REQUIRED_REDIS_VERSION
            ));
        } else {
            $output->writeln(sprintf('<info>yes. You are running NPM version "%s"</info>', $redisVersion));
        }

        $socketIOClient = explode(':', str_replace(['https://', 'http://'], '', $this->getContainer()->getParameter('socket_io.client')));
        $socketIOProcess = new Process(sprintf('nc -zv %s %s; echo $?', $socketIOClient[0], $socketIOClient[1]));
        $socketIOProcess->run();

        if (trim($socketIOProcess->getOutput()) == 0) {
            $output->writeln('<info>Socket I/O server check successful</info>');
        } else {
            $output->writeln('<error>Socket I/O server check failed</error>');
        }
    }
}
