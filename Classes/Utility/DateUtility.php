<?php

namespace RKW\RkwEtracker\Utility;

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
 * Class DateUtility
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DateUtility
{

    /**
     * Gets start and end of last year
     *
     * @param \DateTime $dateLimit
     * @param \DateTime $date
     * @return array
     * @throws \Exception
     */
    public static function getStartEndLastYear(
        \DateTime $date = null,
        \DateTime $dateLimit = null
    ): array {

        if (! $date) {
            $date = new \DateTime();
        }

        $startDate = new \DateTime(($date->format('Y') -1) . '-01-01');
        $endDate = new \DateTime($startDate->format('Y') . '-12-31');

        // check for dateLimit
        if (
            ($dateLimit)
            && ($dateLimit > $startDate)
        ) {
            $startDate = $dateLimit;
        }

        return [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate'   => $endDate->format('Y-m-d'),
            'month' => 0,
            'quarter' => 0,
            'year' => $startDate->format('Y')
        ];
    }


    /**
     * Gets start and end of last quarter
     *
     * @param \DateTime $dateLimit
     * @param \DateTime $date
     * @return array
     * @throws \Exception
     */
    public static function getStartEndLastQuarter(
        \DateTime $date = null,
        \DateTime $dateLimit = null
    ): array {

        if (! $date) {
            $date = new \DateTime();
        }

        // determine last quarter and corresponding year
        $quarter = intval(ceil($date->format('m') / 3) -1);
        if ($quarter == 0) {
            $quarter = 4;
            $date->modify('-1 year');
        }

        $startDate = new \DateTime($date->format('Y') . '-01-01');
        $endDate = new \DateTime($startDate->format('Y') . '-03-01');
        $endDate->setDate($endDate->format('Y'), $endDate->format('m'), $endDate->format('t'));
        switch ($quarter) {
            case 2:
                $startDate = new \DateTime($date->format('Y') . '-04-01');
                $endDate = new \DateTime($startDate->format('Y') . '-06-01');
                $endDate->setDate($endDate->format('Y'), $endDate->format('m'), $endDate->format('t'));
                break;
            case 3:
                $startDate = new \DateTime($date->format('Y') . '-07-01');
                $endDate = new \DateTime($startDate->format('Y') . '-09-01');
                $endDate->setDate($endDate->format('Y'), $endDate->format('m'), $endDate->format('t'));
                break;
            case 4:
                $startDate = new \DateTime($date->format('Y') . '-10-01');
                $endDate = new \DateTime($startDate->format('Y') . '-12-01');
                $endDate->setDate($endDate->format('Y'), $endDate->format('m'), $endDate->format('t'));
                break;
        }

        // check for dateLimit
        if (
            ($dateLimit)
            && ($dateLimit > $startDate)
        ) {
            $startDate = $dateLimit;
        }

        return [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate'   => $endDate->format('Y-m-d'),
            'month' => 0,
            'quarter' => $quarter,
            'year' => $startDate->format('Y')
        ];
    }


    /**
     * Gets start and end of last month
     *
     * @param \DateTime $dateLimit
     * @param \DateTime $date
     * @return array
     * @throws \Exception
     */
    public static function getStartEndLastMonth(
        \DateTime $date = null,
        \DateTime $dateLimit = null
    ): array {

        if (! $date) {
            $date = new \DateTime();
        }

        $startDate = new \DateTime($date->format('Y') . '-' . $date->format('m') . '-01');
        $startDate->modify('-1 month');
        $endDate = new \DateTime($startDate->format('Y') . '-' . $startDate->format('m') . '-' . $startDate->format('t'));

        // check for dateLimit
        if (
            ($dateLimit)
            && ($dateLimit > $startDate)
        ) {
            $startDate = $dateLimit;
        }

        return [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate'   => $endDate->format('Y-m-d'),
            'month' => $startDate->format('n'),
            'quarter' => 0,
            'year' => $startDate->format('Y')
        ];
    }
    /**
     * Gets the date params for the given report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param array $configuration
     * @param \DateTime $date
     * @return array
     * @throws \Exception
     */
    public static function getStartEndForReport(
        \RKW\RkwEtracker\Domain\Model\Report $report,
        array $configuration = [],
        \DateTime $date = null
    ): array {

        if (! $date) {
            $date = new \DateTime();
        }

        // check if we have an accountStartDate
        $dateLimit = null;
        if ($configuration['accountStartDate']) {
            $dateLimit = new \DateTime(date('Y-m-d', strtotime($configuration['accountStartDate'])));
        }

        // default: yearly reports
        $dateArray = DateUtility::getStartEndLastYear($date, $dateLimit);

        // quarterly reports
        if ($report->getType() == 1) {
            $dateArray = DateUtility::getStartEndLastQuarter($date, $dateLimit);

        // monthly reports
        } else if ($report->getType() == 2) {
            $dateArray = DateUtility::getStartEndLastMonth($date, $dateLimit);
        }

        return $dateArray;

    }


    /**
     * Sets the date params for the given report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param array $configuration
     * @param \DateTime $date
     * @return void
     * @throws \Exception
     */
    public static function setStartEndForReport(
        \RKW\RkwEtracker\Domain\Model\Report $report,
        array $configuration = [],
        \DateTime $date = null
    ): void {

        $dateArray = DateUtility::getStartEndForReport($report, $configuration, $date);

        $report->setMonth(intval($dateArray['month']));
        $report->setQuarter(intval($dateArray['quarter']));
        $report->setYear(intval($dateArray['year']));
        $report->setLastStartTstamp(strtotime($dateArray['startDate']));
        $report->setLastEndTstamp(strtotime($dateArray['endDate']));

    }



    /**
     * Sets the date params for the given report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param array $configuration
     * @param \DateTime $date
     * @return bool
     * @throws \Exception
     */
    public static function isReportImportNeeded (
        \RKW\RkwEtracker\Domain\Model\Report $report,
        array $configuration = [],
        \DateTime $date = null
    ): bool {

        if (! $date) {
            $date = new \DateTime();
        }

        $dateArray = DateUtility::getStartEndForReport($report, $configuration, $date);

        if ($report->getLastStartTstamp() >= strtotime($dateArray['startDate'])) {
            return false;
        }

        if ($report->getStarttime() > intval($date->format('U'))) {
            return false;
        }

        return true;
    }

}