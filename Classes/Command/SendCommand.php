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
use RKW\RkwEtracker\Domain\Repository\AreaDataRepository;
use RKW\RkwEtracker\Domain\Repository\DownloadDataRepository;
use RKW\RkwEtracker\Domain\Repository\ReportRepository;
use RKW\RkwEtracker\Etracker\Calculate;
use RKW\RkwEtracker\Etracker\Import;
use RKW\RkwEtracker\Utility\DateUtility;
use Madj2k\Postmaster\Service\MailService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * class sendCommand
 *
 * Execute on CLI with: 'vendor/bin/typo3 rkw_etracker:send'
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SendCommand extends Command
{

    /**
     * @var \RKW\RkwEtracker\Domain\Repository\ReportRepository|null
     */
    protected ?ReportRepository $reportRepository = null;


    /**
     * @var \RKW\RkwEtracker\Domain\Repository\AreaDataRepository|null
     */
    protected ?AreaDataRepository $areaDataRepository = null;


    /**
     * @var \RKW\RkwEtracker\Domain\Repository\DownloadDataRepository|null
     */
    protected ?DownloadDataRepository $downloadDataRepository = null;


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
        $this->setDescription('Send data from eTracker.');
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
        $this->reportRepository = $objectManager->get(ReportRepository::class);
        $this->areaDataRepository = $objectManager->get(AreaDataRepository::class);
        $this->downloadDataRepository = $objectManager->get(DownloadDataRepository::class);

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
        $io->newLine();

        $result = 0;
        try {

            if (
                ($report = $this->reportRepository->findOneByStatus(array(2)))
                && ($this->settings['view']['templateRootPath'])
            ) {

                try {

                    /** @var \Madj2k\Postmaster\Service\MailService $mailService */
                    $mailService = GeneralUtility::makeInstance(MailService::class);

                    // get recipients
                    if ($report->getRecipient()) {

                        $reportData = [];
                        $recipientCnt = 0;

                        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
                        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);

                        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
                        $areaSumObjectStorage = $objectManager->get(ObjectStorage::class);

                        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
                        $downloadSumObjectStorage = $objectManager->get(ObjectStorage::class);

                        /** @var \RKW\RkwEtracker\Etracker\Calculate $calculate */
                        $calculate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(Calculate::class);

                        // sort groups
                        $sortedGroups = $this->sortGroupsByName($report->getGroups());

                        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
                        foreach ($sortedGroups as $reportGroup) {

                            // 1. get all relevant data by filters
                            $areaDataResult = $this->areaDataRepository->findAllByFilters($reportGroup->getFilter(), $report);
                            $downloadData = $this->downloadDataRepository->findAllByFilters($reportGroup->getFilter(), $report);

                            // 2. Calculate sums per group
                            $areaSum = $calculate->getAreaSum($report, $reportGroup, $areaDataResult);
                            $downloadSum = $calculate->getDownloadSum($report, $reportGroup, $downloadData);

                            // 3. save results
                            //$this->areaSumRepository->add($areaSum);
                            $areaSumObjectStorage->attach($areaSum);
                            //$this->downloadSumRepository->add($downloadSum);
                            $downloadSumObjectStorage->attach($downloadSum);

                            $reportData[] = array(
                                'reportGroup'  => $reportGroup,
                                'areaData'     => $areaDataResult,
                                'areaSum'      => $areaSum,
                                'downloadData' => $downloadData,
                                'downloadSum'  => $downloadSum,
                            );
                        }

                        // 4. calculate complete report sums
                        $reportAreaSum = $calculate->getReportAreaSum($report, $areaSumObjectStorage);
                        // $this->reportAreaSumRepository->add($reportAreaSum);

                        /** @todo if we persist it, only the first recipient will get the report sums
                         *  We should nevertheless check how to persist it, because the field in the database get to large
                         *  with the serialized objects!
                         */
                        $reportDownloadSum = $calculate->getReportDownloadSum($report, $downloadSumObjectStorage);
                        //$this->reportDownloadSumRepository->add($reportDownloadSum);
                        //$this->persistenceManager->persistAll();

                        // 5. prepare emails
                        foreach (GeneralUtility::trimExplode(',', $report->getRecipient()) as $recipientEmail) {

                            // validate email
                            if (GeneralUtility::validEmail($recipientEmail)) {

                                $mailService->setTo(
                                    array('email' => $recipientEmail),
                                    array(
                                        'marker' => array(
                                            'report'            => $report,
                                            'reportAreaSum'     => $reportAreaSum,
                                            'reportDownloadSum' => $reportDownloadSum,
                                            'reportData'        => $reportData,
                                            'languageKey'       => $this->settings['settings']['defaultLanguageKey'] ?: 'default',
                                            'singleSignOnPid'   => intval($this->settings['settings']['singleSignOnPid']),

                                        ),
                                    )
                                );
                                $recipientCnt++;
                            }
                        }

                        // 6. set subject
                        $mailService->getQueueMail()->setSubject(
                            $report->getName() . ' (' . date('d.m.Y', $report->getLastStartTstamp())
                            . ' - ' . date('d.m.Y', $report->getLastEndTstamp()) . ')'
                        );

                        // 7. send emails
                        // $mailService->getQueueMail()->setPlaintextTemplate($this->settings['view']['templateRootPath'] . 'Email/Report');
                        $mailService->getQueueMail()->setHtmlTemplate($this->settings['view']['templateRootPath'] . 'Email/Report');

                        if ($recipientCount = count($mailService->getTo())) {
                            $mailService->send();

                            // update timestamp in report to prevent sending it twice
                            $report->setLastMailTstamp(time());
                            $report->setStatus(0);
                            $this->reportRepository->update($report);

                            $message = sprintf(
                                'Successfully send report with id=%s to %s recipients.',
                                $report->getUid(),
                                $recipientCnt
                            );
                            $io->note($message);
                            $this->getLogger()->log(LogLevel::INFO, $message);

                            $result = 1;

                        } else {
                            $message = sprintf(
                                'Could not send report with id=%s.',
                                $report->getUid()
                            );
                            $io->warning($message);
                            $this->getLogger()->log(LogLevel::WARNING, $message);
                        }

                    } else {
                        $message = sprintf(
                            'Report with id=%s has no recipients.',
                            $report->getUid()
                        );
                        $io->warning($message);
                        $this->getLogger()->log(LogLevel::WARNING, $message);
                    }


                } catch (\Exception $e) {

                    $report->setStatus(99);
                    $this->reportRepository->update($report);

                    $message = sprintf(
                        'An error occurred while trying to send reports with id=%s Message: %s',
                        $report->getUid(),
                        str_replace(array("\n", "\r"),
                            '',
                            $e->getMessage()
                        )
                    );
                    $io->error($message);
                    $this->getLogger()->log(LogLevel::ERROR, $message);
                }

            } else {
                $message = 'No report sent.';
                $io->note($message);
                $this->getLogger()->log(LogLevel::INFO, $message);
            }

        } catch (\Exception $e) {

            $message = sprintf('An error occurred while trying to send data from eTracker reports. Message: %s',
                str_replace(array("\n", "\r"), '', $e->getMessage())
            );
            $io->error($message);
            $this->getLogger()->log(LogLevel::ERROR, $message);
        }

        $io->writeln('Done');
        return $result;

    }


    /**
     * Sorting for groups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     * @return array
     */
    protected function sortGroupsByName(ObjectStorage $groups): array
    {
        $sorted = [];

        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
        foreach ($groups as $reportGroup) {
            $sorted[$reportGroup->getName()] = $reportGroup;
        }

        sort($sorted);

        return $sorted;
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
