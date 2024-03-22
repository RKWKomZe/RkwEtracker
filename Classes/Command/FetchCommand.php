<?php
namespace RKW\RkwEtracker\Command;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Madj2k\CoreExtended\Utility\GeneralUtility;
use RKW\RkwEtracker\Domain\Repository\ReportRepository;
use RKW\RkwEtracker\Etracker\Import;
use RKW\RkwEtracker\Utility\DateUtility;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * class FetchCommand
 *
 * Execute on CLI with: 'vendor/bin/typo3 rkw_etracker:fetch'
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class FetchCommand extends Command
{

    /**
     * @var \RKW\RkwEtracker\Domain\Repository\ReportRepository|null
     */
    protected ?ReportRepository $reportRepository = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager|null
     */
    protected ?PersistenceManager $persistenceManager = null;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger = null;


    /**
     * @var array
     */
    protected array $settings = [];


    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure(): void
    {
        $this->setDescription('Fetch data from eTracker.')
            ->addArgument(
                'apiToken',
                InputArgument::REQUIRED,
                'The token for login to eTracker-API',
            )
            ->addOption(
                'proxy',
                'x',
                InputOption::VALUE_REQUIRED,
                'The host name of the proxy (optional).',
                ''
            )
            ->addOption(
                'proxyUsername',
                'u',
                InputOption::VALUE_REQUIRED,
                'The username of the proxy',
                ''
            )
            ->addOption(
                'proxyPassword',
                'p',
                InputOption::VALUE_REQUIRED,
                'The password of the proxy',
                ''
            )
            ->addOption(
                'sleep',
                's',
                InputOption::VALUE_REQUIRED,
                'How many seconds the script should sleep after each data import in the filter groups (default = 1.0)',
                1.0
            )
            ->addOption(
                'groupLimit',
                'g',
                InputOption::VALUE_REQUIRED,
                'Maximum number of filter-groups to fetch at each call (default = 1)',
                1
            );
    }


    /**
     * Initializes the command after the input has been bound and before the input
     * is validated.
     *
     * This is mainly useful when a lot of commands extends one main command
     * where some things need to be initialized based on the input arguments and options.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @see \Symfony\Component\Console\Input\InputInterface::validate()
     * @see \Symfony\Component\Console\Input\InputInterface::bind()
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager$objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var  \RKW\RkwEtracker\Domain\Repository\ReportRepository reportRepository */
        $this->reportRepository = $objectManager->get(ReportRepository::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager persistenceManager */
        $this->persistenceManager = $objectManager->get(PersistenceManager::class);

        $this->settings = $this->getSettings();
    }


    /**
     * Executes the command for showing sys_log entries
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @see \Symfony\Component\Console\Input\InputInterface::bind()
     * @see \Symfony\Component\Console\Input\InputInterface::validate()
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $sleep = $input->getOption('sleep');
        $groupLimit = $input->getOption('groupLimit');

        $io->note('Using sleep="' . $sleep .
            '" and groupLimit="' . $groupLimit. '"'
        );
        $io->newLine();

        $result = 0;
        try {

            if ($report = $this->reportRepository->findOneByTypeAndStatus(DateUtility::getDueReportTypes(), array(0, 1, 89))) {

                try {

                    // build credentials array
                    $credentials = [
                        'apiToken' => $input->getArgument('apiToken'),
                        'proxy' => $input->getOption('proxy'),
                        'proxyUsername' => $input->getOption('proxyUsername'),
                        'proxyPassword' => $input->getOption('proxyPassword')
                    ];

                    /** @var \RKW\RkwEtracker\Etracker\Import $import */
                    $import = GeneralUtility::makeInstance(Import::class);

                    // check if there is something to fetch at all - but only if status is not manually set to "reset" or "fetch running"
                    if ($report->getStatus() == 0) {
                        if (DateUtility::isReportImportNeeded($report)) {
                            $report->setStatus(89);

                            $message = sprintf(
                                'Data-fetch from eTracker API for report with id=%s has been initiated.',
                                $report->getUid()
                            );
                            $io->note($message);
                            $this->getLogger()->log(LogLevel::INFO, $message);
                        }
                    }

                    // this is only to be done for reports with status "reset"
                    // we need to set this values BEFORE we do the real fetch!
                    if ($report->getStatus() == 89) {

                        // set new start and end point for report
                        DateUtility::setStartEndForReport($report, $this->settings);

                        $report->setFetchCounter($report->getFetchCounter() + 1);
                        $report->setStatus(1);

                        // remove all old fetchGroups that may exists for strange reasons
                        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
                        foreach ($report->getGroupsFetch() as $reportGroup) {
                            $report->removeGroupFetch($reportGroup);
                        }

                        // add new fetchGroups
                        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
                        foreach ($report->getGroups() as $reportGroup) {
                            $report->addGroupFetch($reportGroup);
                        }

                        $message = sprintf(
                            'Starting fetching data for report with id=%s from eTracker API.',
                            $report->getUid()
                        );
                        $io->note($message);
                        $this->getLogger()->log(LogLevel::INFO, $message);
                    }

                    // this is only to be done for reports with status "fetch running"
                    if ($report->getStatus() == 1) {

                        // fetch data - one group at once
                        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
                        $cnt = 0;
                        foreach ($report->getGroupsFetch() as $reportGroup) {
                            $import->importAreaData($report, $reportGroup, $credentials);
                            usleep(intval($sleep * 1000000));

                            $import->importDownloadData($report, $reportGroup, $credentials);
                            usleep(intval($sleep * 1000000));

                            $report->removeGroupFetch($reportGroup);
                            $cnt++;

                            if ($cnt >= $groupLimit) {
                                break;
                            }
                        }

                        // if all groups have been fetched, we go over to
                        if (count($report->getGroupsFetch()) < 1) {
                            $report->setLastFetchTstamp(time());
                            $report->setStatus(2);

                            $message = sprintf(
                                'Successfully completed fetching data for report with id=%s from eTracker API.',
                                $report->getUid()
                            );
                            $io->note($message);
                            $this->getLogger()->log(LogLevel::INFO, $message);
                        }
                    }

                    // update report - at least a status change may have happened by checkForImport
                    $this->reportRepository->update($report);
                    $this->persistenceManager->persistAll();

                } catch (\Exception $e) {
                    $report->setStatus(99);
                    $this->reportRepository->update($report);
                    $this->persistenceManager->persistAll();

                    $message = sprintf(
                        'An error occurred while trying to fetch data from eTracker API. Message: %s',
                        str_replace(array("\n", "\r"), '', $e->getMessage())
                    );

                    // @extensionScannerIgnoreLine
                    $io->error($message);
                    $this->getLogger()->log(LogLevel::ERROR, $message);
                    $result = 1;
                }

            } else {
                $message = 'Nothing to fetch from eTracker API.';
                $io->note($message);
                $this->getLogger()->log(LogLevel::INFO, $message);
            }

        } catch (\Exception $e) {

            $message = sprintf('An error occurred while trying to fetch data from eTracker API. Message: %s',
                str_replace(array("\n", "\r"), '', $e->getMessage())
            );

            // @extensionScannerIgnoreLine
            $io->error($message);
            $this->getLogger()->log(LogLevel::ERROR, $message);
            $result = 1;
        }

        $io->writeln('Done');
        return $result;

    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {
        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings(string $which = ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK): array
    {
        return GeneralUtility::getTypoScriptConfiguration('Rkwetracker', $which);
    }
}
