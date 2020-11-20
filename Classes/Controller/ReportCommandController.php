<?php

namespace RKW\RkwEtracker\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use \RKW\RkwMailer\Helper\FrontendLocalization;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use \RKW\RkwBasics\Helper\Common;

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

/**
 * Class ReportCommandController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ReportCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * reportRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = null;

    /**
     * areaDataRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\AreaDataRepository
     * @inject
     */
    protected $areaDataRepository = null;

    /**
     * downloadDataRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\DownloadDataRepository
     * @inject
     */
    protected $downloadDataRepository = null;


    /**
     * areaSumRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\AreaSumRepository
     * @inject
     */
    protected $areaSumRepository = null;

    /**
     * downloadSumRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\DownloadSumRepository
     * @inject
     */
    protected $downloadSumRepository = null;


    /**
     * reportAreaSumRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\ReportAreaSumRepository
     * @inject
     */
    protected $reportAreaSumRepository = null;


    /**
     * reportDownloadSumRepository
     *
     * @var \RKW\RkwEtracker\Domain\Repository\ReportDownloadSumRepository
     * @inject
     */
    protected $reportDownloadSumRepository = null;

    /**
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * The settings.
     *
     * @var array
     */
    protected $settings = array();


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->settings = $this->getSettings();
    }


    /**
     * Fetch data from API
     *
     * @return void
     */
    public function fetchReportDataCommand()
    {

        try {

            if ($report = $this->reportRepository->findOneByStatus(array(0, 1, 89))) {
                try {

                    /** @var \RKW\RkwEtracker\Etracker\Import $import */
                    $import = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\RkwEtracker\Etracker\Import');

                    // check if there is something to fetch at all - but only if status is not manually set to "reset" or "fetch running"
                    if ($report->getStatus() == 0) {
                        $import->checkForImport($report);
                    }

                    // this is only to be done for reports with status "reset"
                    // we need to set this values BEFORE we do the real fetch!
                    if ($report->getStatus() == 89) {
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

                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Starting fetching data for report with id=%s from eTracker API.', $report->getUid()));
                    }

                    // this is only to be done for reports with status "fetch running"
                    if ($report->getStatus() == 1) {

                        // fetch data - one group at once
                        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
                        foreach ($report->getGroupsFetch() as $reportGroup) {
                            $import->importAreaData($report, $reportGroup);
                            $import->importDownloadData($report, $reportGroup);

                            $report->removeGroupFetch($reportGroup);
                            break;
                            //===
                        }

                        // if all groups have been fetched, we go over to
                        if (count($report->getGroupsFetch()) < 1) {
                            $report->setLastFetchTstamp(time());
                            $report->setStatus(2);
                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully completed fetching data for report with id=%s from eTracker API.', $report->getUid()));
                        }
                    }

                    // update report - at least a status change may have happened by checkForImport
                    $this->reportRepository->update($report);

                } catch (\Exception $e) {
                    $report->setStatus(99);
                    $this->reportRepository->update($report);
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to fetch data from eTracker API. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
                }

            } else {
                $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Nothing to fetch from eTracker API.'));
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to fetch data from eTracker API. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
        }
    }


    /**
     * Send the reports
     *
     * @return void
     */
    public function sendReportCommand()
    {
        try {

            if (
                ($report = $this->reportRepository->findOneByStatus(array(2)))
                && ($this->settings['view']['templateRootPath'])
            ) {

                try {

                    /** @var \RKW\RkwMailer\Service\MailService $mailService */
                    $mailService = GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

                    // get recipients
                    if ($report->getRecipient()) {

                        $reportData = array();
                        $recipientCnt = 0;

                        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
                        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

                        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
                        $areaSumObjectStorage = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

                        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
                        $downloadSumObjectStorage = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

                        /** @var \RKW\RkwEtracker\Etracker\Calculate $calculate */
                        $calculate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\RkwEtracker\Etracker\Calculate');

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
                            $this->areaSumRepository->add($areaSum);
                            $areaSumObjectStorage->attach($areaSum);
                            $this->downloadSumRepository->add($downloadSum);
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
                        $this->reportAreaSumRepository->add($reportAreaSum);

                        $reportDownloadSum = $calculate->getReportDownloadSum($report, $downloadSumObjectStorage);
                        $this->reportDownloadSumRepository->add($reportDownloadSum);

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
                                            'languageKey'       => $this->settings['settings']['defaultLanguageKey'] ? $this->settings['settings']['defaultLanguageKey'] : 'default',
                                            'singleSignOnPid'   => intval($this->settings['settings']['singleSignOnPid']),

                                        ),
                                    )
                                );
                                $recipientCnt++;
                            }
                        }

                        // 6. set subject
                        $mailService->getQueueMail()->setSubject($report->getName() . ' (' . date('d.m.Y', $report->getLastStartTstamp()) . ' - ' . date('d.m.Y', $report->getLastEndTstamp()) . ')');

                        // 7. send emails
                        // $mailService->getQueueMail()->setPlaintextTemplate($this->settings['view']['templateRootPath'] . 'Email/Report');
                        $mailService->getQueueMail()->setHtmlTemplate($this->settings['view']['templateRootPath'] . 'Email/Report');

                        if ($recipientCount = count($mailService->getTo())) {
                            $mailService->send();

                            // update timestamp in report to prevent sending it twice
                            $report->setLastMailTstamp(time());
                            $report->setStatus(0);
                            $this->reportRepository->update($report);

                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully send report with id=%s to %s recipients.', $report->getUid(), $recipientCnt));
                        } else {
                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, sprintf('Could not send report with id=%s.', $report->getUid()));
                        }

                    } else {
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, sprintf('Report with id=%s has no recipients.', $report->getUid()));
                    }


                } catch (\Exception $e) {

                    $report->setStatus(99);
                    $this->reportRepository->update($report);
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to send reports with id=%s Message: %s', $report->getUid(), str_replace(array("\n", "\r"), '', $e->getMessage())));

                }

            } else {
                $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('No report sent.'));
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to send reports. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
        }
    }


    /**
     * Sorting for groups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     * @return array
     */
    protected function sortGroupsByName($groups)
    {

        $sorted = array();

        /** @var \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup */
        foreach ($groups as $reportGroup) {
            $sorted[$reportGroup->getName()] = $reportGroup;
        }

        sort($sorted);

        return $sorted;
        //===
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
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
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)
    {

        return Common::getTyposcriptConfiguration('Rkwetracker', $which);
    }
}
