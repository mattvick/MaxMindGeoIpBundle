<?php

namespace Insomnia\MaxMindGeoIpBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * User: avasilenko
 * Date: 29.08.14
 * Time: 11:27
 */
class LoadDatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('insomnia:geoip:update')
            ->setDescription('Update the MaxMind GeoIp data')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'The url source file to download and unzip')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command download and install the MaxMind GeoIp data source

To install the GeoLiteCountry:
<info>php %command.full_name% http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.mmdb.gz</info>

To install the GeoLite City:
<info>php %command.full_name% http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz</info>

more information here: http://dev.maxmind.com/geoip/geoip2/geolite2/

EOT
            )
        ;
    }

    /**
     * @todo handle failed downloads
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Download
        $source = $input->getArgument('source');
        $tmpFile = tempnam(sys_get_temp_dir(), 'maxmind_geoip');
        $output->writeln(sprintf('<info>Downloading %s</info>', $source));
        $output->writeln('...');
        $fs = new Filesystem();
        try {
            $fs->copy($source, $tmpFile);
        } catch (IOExceptionInterface $e) {
            $output->writeln('<error>An error occurred while downloading the file</error>');
            return;
        }
        $output->writeln('<info>Download complete</info>');

        // Extract
        $destination = $this->getContainer()->getParameter('insomnia_max_mind_db_path');
        $output->writeln('<info>Extracting the downloaded file</info>');
        $output->writeln('...');
        $cmd = 'gzip -dc ' . escapeshellarg($tmpFile) . ' > ' . escapeshellarg($destination);
        $process = new Process($cmd);
        $process->run();
        if (!$process->isSuccessful()) {
            // throw new ProcessFailedException($process);
            $output->writeln('<error>Unable to ungzip file</error>');
            $output->writeln(sprintf('<error>Command: %s</error>', $cmd));
            $output->writeln(sprintf('<error>Output: %s</error>', $process->getOutput()));
            return;
        }
        $output->writeln('<info>Unzip completed</info>');
    }
} 