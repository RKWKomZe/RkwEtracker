<?php
namespace RKW\RkwEtracker\Etracker;

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

use RKW\RkwEtracker\Domain\Model\AreaSum;
use RKW\RkwEtracker\Domain\Model\DownloadSum;
use RKW\RkwEtracker\Domain\Model\Report;
use RKW\RkwEtracker\Domain\Model\ReportAreaSum;
use RKW\RkwEtracker\Domain\Model\ReportDownloadSum;
use RKW\RkwEtracker\Domain\Model\ReportGroup;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;


/**
 * Class Calcutate
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class Calculate
{

    /**
     * Calculates the area sums for a report group
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|null $results
     * @return \RKW\RkwEtracker\Domain\Model\AreaSum
     */
    public function getAreaSum(Report $report, ReportGroup $reportGroup, ?QueryResultInterface $results): AreaSum
    {

        /** @var \RKW\RkwEtracker\Domain\Model\AreaSum $areaSum */
        $areaSum = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(AreaSum::class);

        // set basic data
        $areaSum->setReport($report);
        $areaSum->setReportGroup($reportGroup);
        $areaSum->setReportFetchCounter($report->getFetchCounter());
        $areaSum->setMonth($report->getMonth());
        $areaSum->setQuarter($report->getQuarter());
        $areaSum->setYear($report->getYear());

        // sum up values for area data
        /** @var \RKW\RkwEtracker\Domain\Model\AreaData $groupAreaData */
        if (
            ($results instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface)
            && count($results)
        ) {

            $sumCounter = 0;
            foreach ($results as $groupAreaData) {

                if (!$groupAreaData->getVisits()) {
                    continue;
                    //===
                }

                $areaSum->setVisits($areaSum->getVisits() + $groupAreaData->getVisits());
                $areaSum->setVisitors($areaSum->getVisitors() + $groupAreaData->getVisitors());
                $areaSum->setPageImpressions($areaSum->getPageImpressions() + $groupAreaData->getPageImpressions());
                $areaSum->setTimePerVisit($areaSum->getTimePerVisit() + $groupAreaData->getTimePerVisit());
                $areaSum->setBouncesPerVisit($areaSum->getBouncesPerVisit() + $groupAreaData->getBouncesPerVisit());
                $sumCounter++;
            }

            // calculate some averages and add results to repository
            if ($sumCounter > 0) {
                $areaSum->setPageImpressionsPerVisit(floatval($areaSum->getPageImpressions() / $areaSum->getVisits()));
                $areaSum->setTimePerVisit(intval($areaSum->getTimePerVisit() / $sumCounter));
                $areaSum->setBouncesPerVisit(intval($areaSum->getBouncesPerVisit() / $sumCounter));
            }
        }

        return $areaSum;
        //===
    }


    /**
     * Calculates the area sums for a report group
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|null $results
     * @return \RKW\RkwEtracker\Domain\Model\DownloadSum
     */
    public function getDownloadSum(Report $report,ReportGroup $reportGroup, ?QueryResultInterface $results): DownloadSum
    {

        /** @var \RKW\RkwEtracker\Domain\Model\DownloadSum $downloadSum */
        $downloadSum = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(DownloadSum::class);

        // set basic data
        $downloadSum->setReport($report);
        $downloadSum->setReportFetchCounter($report->getFetchCounter());
        $downloadSum->setReportGroup($reportGroup);
        $downloadSum->setMonth($report->getMonth());
        $downloadSum->setQuarter($report->getQuarter());
        $downloadSum->setYear($report->getYear());

        if (
            ($results instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface)
            && count($results)
        ) {
            // sum up values for area data
            /** @var \RKW\RkwEtracker\Domain\Model\DownloadData $groupDownloadData */
            $sumCounter = 0;
            foreach ($results as $groupDownloadData) {

                if (!$groupDownloadData->getEvents()) {
                    continue;
                    //===
                }

                $downloadSum->setEvents($downloadSum->getEvents() + $groupDownloadData->getEvents());
                $downloadSum->setUniqueEvents($downloadSum->getUniqueEvents() + $groupDownloadData->getUniqueEvents());
                $downloadSum->setTimePerEvent($downloadSum->getTimePerEvent() + $groupDownloadData->getTimePerEvent());
                $sumCounter++;
            }

            // calculate some averages and add results to repository
            if ($sumCounter > 0) {
                $downloadSum->setTimePerEvent(floatval($downloadSum->getTimePerEvent() / $sumCounter));
            }
        }

        return $downloadSum;
        //===
    }


    /**
     * Calculates the report area sums for a complete report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\AreaSum> $areaSums
     * @return \RKW\RkwEtracker\Domain\Model\ReportAreaSum
     */
    public function getReportAreaSum(Report $report, ObjectStorage $areaSums): ReportAreaSum
    {

        /** @var \RKW\RkwEtracker\Domain\Model\ReportAreaSum $reportAreaSum */
        $reportAreaSum = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ReportAreaSum::class);

        // set basic data
        $reportAreaSum->setReport($report);
        $reportAreaSum->setReportFetchCounter($report->getFetchCounter());
        $reportAreaSum->setMonth($report->getMonth());
        $reportAreaSum->setQuarter($report->getQuarter());
        $reportAreaSum->setYear($report->getYear());

        // sum up values for area sums
        /** @var \RKW\RkwEtracker\Domain\Model\AreaSum $areaSumData */
        if (
            ($areaSums instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage)
            && count($areaSums)
        ) {
            $sumCounter = 0;
            foreach ($areaSums as $areaSumData) {

                if (!$areaSumData->getVisits()) {
                    continue;
                    //===
                }

                $reportAreaSum->setVisits($reportAreaSum->getVisits() + $areaSumData->getVisits());
                $reportAreaSum->setVisitors($reportAreaSum->getVisitors() + $areaSumData->getVisitors());
                $reportAreaSum->setPageImpressions($reportAreaSum->getPageImpressions() + $areaSumData->getPageImpressions());
                $reportAreaSum->setPageImpressionsPerVisit($reportAreaSum->getPageImpressionsPerVisit() + $areaSumData->getPageImpressionsPerVisit());
                $reportAreaSum->setTimePerVisit($reportAreaSum->getTimePerVisit() + $areaSumData->getTimePerVisit());
                $reportAreaSum->setBouncesPerVisit($reportAreaSum->getBouncesPerVisit() + $areaSumData->getBouncesPerVisit());
                $sumCounter++;
            }

            // calculate some averages and add results to repository
            if ($sumCounter > 0) {
                $reportAreaSum->setPageImpressionsPerVisit(floatval($reportAreaSum->getPageImpressionsPerVisit() / $sumCounter));
                $reportAreaSum->setTimePerVisit(intval($reportAreaSum->getTimePerVisit() / $sumCounter));
                $reportAreaSum->setBouncesPerVisit(intval($reportAreaSum->getBouncesPerVisit() / $sumCounter));
            }

        }

        return $reportAreaSum;
        //===
    }


    /**
     * Calculates the area sums for a report group
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\DownloadSum> $downloadSums
     * @return \RKW\RkwEtracker\Domain\Model\ReportDownloadSum
     */
    public function getReportDownloadSum(Report $report, ObjectStorage $downloadSums): ReportDownloadSum
    {

        /** @var \RKW\RkwEtracker\Domain\Model\ReportDownloadSum $reportDownloadSum */
        $reportDownloadSum = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ReportDownloadSum::class);

        // set basic data
        $reportDownloadSum->setReport($report);
        $reportDownloadSum->setReportFetchCounter($report->getFetchCounter());
        $reportDownloadSum->setMonth($report->getMonth());
        $reportDownloadSum->setQuarter($report->getQuarter());
        $reportDownloadSum->setYear($report->getYear());

        if (
            ($downloadSums instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage)
            && count($downloadSums)
        ) {

            // sum up values for download sums
            /** @var \RKW\RkwEtracker\Domain\Model\DownloadSum $downloadSum */
            $sumCounter = 0;
            foreach ($downloadSums as $downloadSum) {

                if (!$downloadSum->getEvents()) {
                    continue;
                    //===
                }

                $reportDownloadSum->setEvents($reportDownloadSum->getEvents() + $downloadSum->getEvents());
                $reportDownloadSum->setUniqueEvents($reportDownloadSum->getUniqueEvents() + $downloadSum->getUniqueEvents());
                $reportDownloadSum->setTimePerEvent($reportDownloadSum->getTimePerEvent() + $downloadSum->getTimePerEvent());
                $sumCounter++;
            }

            // calculate some averages and add results to repository
            if ($sumCounter > 0) {
                $reportDownloadSum->setTimePerEvent(floatval($reportDownloadSum->getTimePerEvent() / $sumCounter));
            }
        }

        return $reportDownloadSum;
    }


}
